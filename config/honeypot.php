<?php

use Sfneal\Honeypot\Responders\HoneyCaughtResponder;

return [
    /*
     * Here you can specify name of the honeypot field. Any requests that submit a non-empty
     * value for this name will be discarded. Make sure this name does not
     * collide with a form field that is actually used.
     */
    'name_field_name' => env('HONEYPOT_NAME', 'my_name'),

    /*
     * When this is activated there will be a random string added
     * to the name_field_name. This improves the
     * protection against bots.
     */
    'randomize_name_field_name' => env('HONEYPOT_RANDOMIZE', true),

    /*
     * This field contains the name of a form field that will be used to verify
     * if the form wasn't submitted too quickly. Make sure this name does not
     * collide with a form field that is actually used.
     */
    'valid_from_field_name' => env('HONEYPOT_VALID_FROM', 'valid_from'),

    /*
     * If the form is submitted faster than this amount of seconds
     * the form submission will be considered invalid.
     */
    'amount_of_seconds' => env('HONEYPOT_SECONDS', 1),

    /*
     * This class is responsible for sending a response to requests that
     * are detected as being spammy. By default a blank page is shown.
     *
     * A valid responder is any class that implements
     * `Spatie\Honeypot\SpamResponder\SpamResponder`
     */
    'respond_to_spam_with' => HoneyCaughtResponder::class,

    /*
     * This switch determines if the honeypot protection should be activated.
     */
    'enabled' => env('HONEYPOT_ENABLED', true),

    /*
     * Response content returned when a request is determined to be spam.
     */
    'response_content' => "If you're a robot, you've been caught by a human.  If you're a human, another human has mistaken you for a robot.",

    /*
     * Enable Honeypot traps & specify input names.
     */
    'traps' => [
        /*
         * Catch spam requests that submit an identical 'first' & 'last' name inputs.
         */
        'duplicate_names' => [
            /*
             * This switch determines if the 'duplicate_names' trap is enabled
             */
            'enabled' => false,

            /*
             * Name of the 'first name' attribute used in Honeypot request
             */
            'name_first_input' => 'data.name_first',

            /*
             * Name of the 'last name' attribute used in Honeypot request
             */
            'name_last_input' => 'data.name_last',
        ],
    ],
];
