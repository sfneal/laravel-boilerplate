<?php

namespace App\Providers;

use Domain\Articles\Events\ArticleSavedEvent;
use Domain\Articles\Listeners\ProcessArticleListener;
use Domain\Awards\Events\AwardSavedEvent;
use Domain\Awards\Listeners\SyncAwardProjectsListener;
use Domain\Clients\Events\InquiryCreatedEvent;
use Domain\Clients\Events\InquiryDeletedEvent;
use Domain\Clients\Events\InquiryUpdatedEvent;
use Domain\Clients\Events\MessageSavedEvent;
use Domain\Clients\Events\SubscriptionCreatedEvent;
use Domain\Clients\Listeners\DeleteBlockedSenderInquiryListener;
use Domain\Clients\Listeners\InquiryConfirmationListener;
use Domain\Clients\Listeners\InquiryDeletedListener;
use Domain\Clients\Listeners\InquirySitePlanMissingListener;
use Domain\Clients\Listeners\NotifyNewInquiryListener;
use Domain\Clients\Listeners\ProcessInquiryPdfListener;
use Domain\Clients\Listeners\SendMessageListener;
use Domain\Clients\Listeners\SubscriptionConfirmationListener;
use Domain\Plans\Events\PlanDeletedEvent;
use Domain\Plans\Events\PlanManagementSavedEvent;
use Domain\Plans\Events\PlanSavedEvent;
use Domain\Plans\Listeners\BucketChangedListener;
use Domain\Plans\Listeners\BuildingTypeChangedListener;
use Domain\Plans\Listeners\DeletePlanBinderListener;
use Domain\Plans\Listeners\DestroyPlanFloorsListener;
use Domain\Plans\Listeners\UpdatePlanDescriptionListener;
use Domain\Portfolio\Events\PortfolioDeletedEvent;
use Domain\Portfolio\Listeners\PortfolioDeletedListener;
use Domain\Projects\Events\BuildingDeletedEvent;
use Domain\Projects\Events\ProjectRateDeletedEvent;
use Domain\Projects\Events\ProjectRateSavedEvent;
use Domain\Projects\Events\ProjectSavedEvent;
use Domain\Projects\Events\ProjectUpdatedEvent;
use Domain\Projects\Events\SubdivisionSavedEvent;
use Domain\Projects\Listeners\BuildingDeletedListener;
use Domain\Projects\Listeners\CloseProjectTasksListener;
use Domain\Projects\Listeners\CreateDefaultModelListener;
use Domain\Projects\Listeners\CreateDefaultUnitListener;
use Domain\Projects\Listeners\ReopenProjectListener;
use Domain\Projects\Listeners\SyncProjectUsersListener;
use Domain\Projects\Listeners\UpdatePlanManagementProgressListener;
use Domain\Projects\Listeners\UpdateProjectPhaseListener;
use Domain\Projects\Listeners\UpdateSubdivisionPdfListener;
use Domain\Tasks\Events\TaskCreatedEvent;
use Domain\Tasks\Events\TaskRecordCreatedEvent;
use Domain\Tasks\Events\TaskSavedEvent;
use Domain\Tasks\Listeners\OverrideTaskRateListener;
use Domain\Tasks\Listeners\ResetTaskRateListener;
use Domain\Tasks\Listeners\UpdateProjectRateListener;
use Domain\Transmittals\Events\TransmittalDeletedEvent;
use Domain\Transmittals\Listeners\DeleteTransmittalRecipientsListener;
use Domain\Users\Events\UserUpdatedEvent;
use Domain\Users\Listeners\UserRateChangedListener;
use Domain\Users\Listeners\UserStatusChangedListener;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Sfneal\Tracking\Listeners\TrackActivityListener;
use Support\Files\Events\DeletedFileModelsParentEvent;
use Support\Files\Events\FileDeletedEvent;
use Support\Files\Listeners\DeletedFileModelsParentListener;
use Support\Files\Listeners\DeleteFileParentListener;
use Support\Files\Listeners\DeleteFileSharesListener;
use Support\Files\Listeners\DeleteUnusedFilesListener;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        // Article Saved
        ArticleSavedEvent::class => [
            ProcessArticleListener::class,
            TrackActivityListener::class,
        ],

        // Award Saved
        AwardSavedEvent::class => [
            SyncAwardProjectsListener::class,
            TrackActivityListener::class,
        ],

        // Building Deleted
        BuildingDeletedEvent::class => [
            BuildingDeletedListener::class,
            TrackActivityListener::class,
        ],

        // Deleted Model - delete S3 Files
        FileDeletedEvent::class => [
            DeleteFileParentListener::class,
            DeleteUnusedFilesListener::class,
            DeleteFileSharesListener::class,
        ],

        // Deleted related File models
        DeletedFileModelsParentEvent::class => [
            DeletedFileModelsParentListener::class,
        ],

        // Inquiry Created
        InquiryCreatedEvent::class => [
            DeleteBlockedSenderInquiryListener::class,
            ProcessInquiryPdfListener::class,
            InquiryConfirmationListener::class,
            InquirySitePlanMissingListener::class,
            NotifyNewInquiryListener::class,
            TrackActivityListener::class,
        ],

        // Inquiry Updated
        InquiryUpdatedEvent::class => [
            ProcessInquiryPdfListener::class,
            NotifyNewInquiryListener::class,
            TrackActivityListener::class,
        ],

        // Inquiry Deleted
        InquiryDeletedEvent::class => [
            InquiryDeletedListener::class,
            DeletedFileModelsParentListener::class,
            TrackActivityListener::class,
        ],

        // Message Saved
        MessageSavedEvent::class => [
            SendMessageListener::class,
            TrackActivityListener::class,
        ],

        // Plan Saved
        PlanSavedEvent::class => [
            BuildingTypeChangedListener::class,
            UpdatePlanManagementProgressListener::class,
            UpdatePlanDescriptionListener::class,
            TrackActivityListener::class,
        ],

        // Plan Deleted
        PlanDeletedEvent::class => [
            DestroyPlanFloorsListener::class,
            DeletePlanBinderListener::class,
            TrackActivityListener::class,
        ],

        // Plan Management Updated
        PlanManagementSavedEvent::class => [
            BucketChangedListener::class,
        ],

        // Portfolio Deleted
        PortfolioDeletedEvent::class => [
            PortfolioDeletedListener::class,
            DeletedFileModelsParentListener::class,
            TrackActivityListener::class,
        ],

        // Project Saved
        ProjectSavedEvent::class => [
            CreateDefaultUnitListener::class,
            SyncProjectUsersListener::class,
            UpdatePlanManagementProgressListener::class,
            TrackActivityListener::class,
        ],

        // Project Updated
        ProjectUpdatedEvent::class => [
            CreateDefaultModelListener::class,
            CloseProjectTasksListener::class,
            TrackActivityListener::class,
        ],

        // Project Rate Saved
        ProjectRateSavedEvent::class => [
            OverrideTaskRateListener::class,
        ],

        // Project Rate Deleted
        ProjectRateDeletedEvent::class => [
            ResetTaskRateListener::class,
        ],

        // Subscription Created
        SubscriptionCreatedEvent::class => [
            SubscriptionConfirmationListener::class,
        ],

        // Subdivision Saved
        SubdivisionSavedEvent::class => [
            UpdateSubdivisionPdfListener::class,
            TrackActivityListener::class,
        ],

        // Task Created
        TaskCreatedEvent::class => [
            UpdateProjectRateListener::class,
        ],

        // Task Saved
        TaskSavedEvent::class => [
            SyncProjectUsersListener::class,
            ReopenProjectListener::class,
            TrackActivityListener::class,
        ],

        // TaskRecord Created
        TaskRecordCreatedEvent::class => [
            UpdateProjectPhaseListener::class,
        ],

        // Transmittal Deleted
        TransmittalDeletedEvent::class => [
            DeleteTransmittalRecipientsListener::class,
            DeletedFileModelsParentListener::class,
        ],

        // User Updating
        UserUpdatedEvent::class => [
            UserRateChangedListener::class,
            UserStatusChangedListener::class,
            TrackActivityListener::class,
        ],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();
    }
}
