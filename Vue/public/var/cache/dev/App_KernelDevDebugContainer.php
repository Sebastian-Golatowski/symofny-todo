<?php

// This file has been auto-generated by the Symfony Dependency Injection Component for internal use.

if (\class_exists(\ContainerIl6wDQl\App_KernelDevDebugContainer::class, false)) {
    // no-op
} elseif (!include __DIR__.'/ContainerIl6wDQl/App_KernelDevDebugContainer.php') {
    touch(__DIR__.'/ContainerIl6wDQl.legacy');

    return;
}

if (!\class_exists(App_KernelDevDebugContainer::class, false)) {
    \class_alias(\ContainerIl6wDQl\App_KernelDevDebugContainer::class, App_KernelDevDebugContainer::class, false);
}

return new \ContainerIl6wDQl\App_KernelDevDebugContainer([
    'container.build_hash' => 'Il6wDQl',
    'container.build_id' => '608919d3',
    'container.build_time' => 1686344239,
], __DIR__.\DIRECTORY_SEPARATOR.'ContainerIl6wDQl');