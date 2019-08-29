<?php

namespace Translation\PlatformAdapter\Doctrine\Bridge\Symfony;

use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * @author Yenkong Lybliamay <yenkong@lybliamay.fr>
 */
class TranslationAdapterDoctrineBundle extends Bundle
{
    /**
     * Returns the bundle name that this bundle overrides.
     *
     * Despite its name, this method does not imply any parent/child relationship
     * between the bundles, just a way to extend and override an existing
     * bundle.
     *
     * @return string The Bundle name it overrides or null if no parent
     *
     * @deprecated This method is deprecated as of 3.4 and will be removed in 4.0.
     */
    public function getParent()
    {
        return null;
    }
}
