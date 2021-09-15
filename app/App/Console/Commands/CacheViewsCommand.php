<?php

namespace App\Console\Commands;

use Domain\Faqs\ViewModels\FaqViewModel;
use Domain\Plans\Models\Plan;
use Domain\Services\Models\Service;
use Domain\Tasks\Jobs\CacheBillableProjectsViewJob;
use PublicSite\About\ViewModels\PublicAboutViewModel;
use PublicSite\About\ViewModels\PublicArticleViewModel;
use PublicSite\About\ViewModels\PublicAwardsViewModel;
use PublicSite\About\ViewModels\PublicFirmViewModel;
use PublicSite\About\ViewModels\PublicTeamViewModel;
use PublicSite\About\ViewModels\PublicTestimonialViewModel;
use PublicSite\Contact\ViewModels\InquiryClientCreateViewModel;
use PublicSite\Legal\ViewModels\CopyrightViewModel;
use PublicSite\Legal\ViewModels\GlossaryViewModel;
use PublicSite\Legal\ViewModels\LicenseViewModel;
use PublicSite\Legal\ViewModels\PrivacyViewModel;
use PublicSite\Legal\ViewModels\TermsViewModel;
use PublicSite\Plans\ViewModels\PublicPlanSearchViewModel;
use PublicSite\Plans\ViewModels\PublicPlanShowViewModel;
use PublicSite\Portfolio\ViewModels\PublicPortfolioIndexViewModel;
use PublicSite\Service\ViewModels\ProcessViewModel;
use PublicSite\Service\ViewModels\ServiceIndexViewModel;
use PublicSite\Service\ViewModels\ServiceShowViewModel;
use Sfneal\ViewModels\PreCacheViewModel;

class CacheViewsCommand extends AbstractCommand
{
    // todo: consider debugging/enhancing this by adding job middleware

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'view:pre-cache {views=all}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Execute commands intended to be run on application start';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // Call arguments
        $this->{$this->argument('views')}();
    }

    /**
     * All portal & public site ViewModels.
     *
     * @return void
     */
    private function all()
    {
        $this->public();
        $this->portal();
    }

    /**
     * Public site cacheable ViewModels.
     *
     * @return array
     */
    private function public()
    {
        $chains = [
            // About
            PreCacheViewModel::dispatch(new PublicAboutViewModel(), 'public.about.index'),
            PreCacheViewModel::dispatch(new PublicArticleViewModel(), 'public.about.articles'),
            PreCacheViewModel::dispatch(new PublicAwardsViewModel(), 'public.about.awards'),
            PreCacheViewModel::dispatch(new PublicFirmViewModel(), 'public.about.firm'),
            PreCacheViewModel::dispatch(new PublicTeamViewModel(), 'public.about.team'),
            PreCacheViewModel::dispatch(new PublicTestimonialViewModel(), 'public.about.testimonials'),

            // Inquiries
            PreCacheViewModel::dispatch(new InquiryClientCreateViewModel(), 'public.contact.client-inquiry.create'),

            // Documentation
            PreCacheViewModel::dispatch(new CopyrightViewModel(), 'public.copyright.index'),
            PreCacheViewModel::dispatch(new FaqViewModel(), 'public.faq.index'),
            PreCacheViewModel::dispatch(new GlossaryViewModel(), 'public.glossary.index'),
            PreCacheViewModel::dispatch(new LicenseViewModel(), 'public.license.index'),
            PreCacheViewModel::dispatch(new PrivacyViewModel(), 'public.privacy.index'),
            PreCacheViewModel::dispatch(new TermsViewModel(), 'public.terms.index'),

            // Plans
            PreCacheViewModel::dispatch(new PublicPlanSearchViewModel(), 'public.plan.index'),

            // Portfolio
            PreCacheViewModel::dispatch(new PublicPortfolioIndexViewModel(), 'public.portfolio.index'),

            // Services
            PreCacheViewModel::dispatch(new ServiceIndexViewModel(), 'public.service.index'),
            PreCacheViewModel::dispatch(new ProcessViewModel(), 'public.service.process'),
        ];

        Service::all()->each(function (Service $service) {
            PreCacheViewModel::dispatch(
                new ServiceShowViewModel($service->getKey()),
                'public.service.show',
                ['service_id'=> $service->getKey()]
            );
        });

        Plan::query()
            ->wherePublic()
            ->orderBy('publish_date', 'desc')
            ->limit(20)
            ->get()->each(function (Plan $plan) {
                PreCacheViewModel::dispatch(
                    new PublicPlanShowViewModel($plan->getKey()),
                    'public.plan.show',
                    ['plan_id'=> $plan->getKey()],
                );
            });

        return $chains;
    }

    /**
     * Portal site cacheable ViewModels.
     *
     * @return void
     */
    private function portal()
    {
        CacheBillableProjectsViewJob::dispatch(null, null);
        CacheBillableProjectsViewJob::dispatch(true, null);
        CacheBillableProjectsViewJob::dispatch(true, true);
        CacheBillableProjectsViewJob::dispatch(null, true);
    }
}
