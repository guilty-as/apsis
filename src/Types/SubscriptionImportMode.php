<?php


namespace Guilty\Apsis\Types;


class SubscriptionImportMode
{
    /**
     * Adds the subscribers from the import file to the selected mailing list;
     * allows adding and updating subscriptions, but not deleting subscriptions
     */
    const IMPORT = "Import";

    /**
     * Makes sure the selected mailing list contains only the subscribers from the import file;
     * allows adding, updating and deleting subscriptions.
     */
    const SYNC = "Sync";
}