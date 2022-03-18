<?php
    function gitVersion()
    {
        $version = \Tremby\LaravelGitVersion\GitVersionHelper::getVersion();
        return explode('-', $version)[0];
    }
?>
