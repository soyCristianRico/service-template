<?php
use App\Enums\LandingStatus;
use App\Models\Category;
use App\Models\Location;
use App\Models\Landing;
use Livewire\Attributes\Computed;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;
?>

<div class="space-y-6 p-8">
    <div class="flex items-center justify-between">
        <?php if (isset($component)) { $__componentOriginale0fd5b6a0986beffac17a0a103dfd7b9 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginale0fd5b6a0986beffac17a0a103dfd7b9 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'e60dd9d2c3a62d619c9acb38f20d5aa5::heading','data' => ['size' => 'xl']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('flux::heading'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['size' => 'xl']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>
Landings <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginale0fd5b6a0986beffac17a0a103dfd7b9)): ?>
<?php $attributes = $__attributesOriginale0fd5b6a0986beffac17a0a103dfd7b9; ?>
<?php unset($__attributesOriginale0fd5b6a0986beffac17a0a103dfd7b9); ?>
<?php endif; ?>
<?php if (isset($__componentOriginale0fd5b6a0986beffac17a0a103dfd7b9)): ?>
<?php $component = $__componentOriginale0fd5b6a0986beffac17a0a103dfd7b9; ?>
<?php unset($__componentOriginale0fd5b6a0986beffac17a0a103dfd7b9); ?>
<?php endif; ?>
        <div class="flex gap-2">
            <?php if (isset($component)) { $__componentOriginalc04b147acd0e65cc1a77f86fb0e81580 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc04b147acd0e65cc1a77f86fb0e81580 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'e60dd9d2c3a62d619c9acb38f20d5aa5::button.index','data' => ['href' => route('admin.landings.matrix'),'variant' => 'ghost','icon' => 'squares-2x2']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('flux::button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('admin.landings.matrix')),'variant' => 'ghost','icon' => 'squares-2x2']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>
Matriz <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc04b147acd0e65cc1a77f86fb0e81580)): ?>
<?php $attributes = $__attributesOriginalc04b147acd0e65cc1a77f86fb0e81580; ?>
<?php unset($__attributesOriginalc04b147acd0e65cc1a77f86fb0e81580); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc04b147acd0e65cc1a77f86fb0e81580)): ?>
<?php $component = $__componentOriginalc04b147acd0e65cc1a77f86fb0e81580; ?>
<?php unset($__componentOriginalc04b147acd0e65cc1a77f86fb0e81580); ?>
<?php endif; ?>
            <?php if (isset($component)) { $__componentOriginalc04b147acd0e65cc1a77f86fb0e81580 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc04b147acd0e65cc1a77f86fb0e81580 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'e60dd9d2c3a62d619c9acb38f20d5aa5::button.index','data' => ['href' => route('admin.landings.create'),'variant' => 'primary','icon' => 'plus']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('flux::button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('admin.landings.create')),'variant' => 'primary','icon' => 'plus']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>
Nueva landing <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc04b147acd0e65cc1a77f86fb0e81580)): ?>
<?php $attributes = $__attributesOriginalc04b147acd0e65cc1a77f86fb0e81580; ?>
<?php unset($__attributesOriginalc04b147acd0e65cc1a77f86fb0e81580); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc04b147acd0e65cc1a77f86fb0e81580)): ?>
<?php $component = $__componentOriginalc04b147acd0e65cc1a77f86fb0e81580; ?>
<?php unset($__componentOriginalc04b147acd0e65cc1a77f86fb0e81580); ?>
<?php endif; ?>
        </div>
    </div>

    <div class="grid gap-3 md:grid-cols-4">
        <?php if (isset($component)) { $__componentOriginal26c546557cdc09040c8dd00b2090afd0 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal26c546557cdc09040c8dd00b2090afd0 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'e60dd9d2c3a62d619c9acb38f20d5aa5::input.index','data' => ['wire:model.live.debounce.300ms' => 'search','type' => 'search','placeholder' => 'Buscar por slug…','icon' => 'magnifying-glass']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('flux::input'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model.live.debounce.300ms' => 'search','type' => 'search','placeholder' => 'Buscar por slug…','icon' => 'magnifying-glass']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal26c546557cdc09040c8dd00b2090afd0)): ?>
<?php $attributes = $__attributesOriginal26c546557cdc09040c8dd00b2090afd0; ?>
<?php unset($__attributesOriginal26c546557cdc09040c8dd00b2090afd0); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal26c546557cdc09040c8dd00b2090afd0)): ?>
<?php $component = $__componentOriginal26c546557cdc09040c8dd00b2090afd0; ?>
<?php unset($__componentOriginal26c546557cdc09040c8dd00b2090afd0); ?>
<?php endif; ?>
        <?php if (isset($component)) { $__componentOriginala467913f9ff34913553be64599ec6e92 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala467913f9ff34913553be64599ec6e92 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'e60dd9d2c3a62d619c9acb38f20d5aa5::select.index','data' => ['variant' => 'listbox','searchable' => true,'clearable' => true,'wire:model.live' => 'categoryId','placeholder' => 'Todas las categorías']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('flux::select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['variant' => 'listbox','searchable' => true,'clearable' => true,'wire:model.live' => 'categoryId','placeholder' => 'Todas las categorías']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $this->categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                <?php if (isset($component)) { $__componentOriginalc7395a5f1f6c2e275d1dc4ea0be0c745 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc7395a5f1f6c2e275d1dc4ea0be0c745 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'e60dd9d2c3a62d619c9acb38f20d5aa5::select.option.index','data' => ['value' => ''.e($category->id).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('flux::select.option'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['value' => ''.e($category->id).'']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>
<?php echo e($category->name); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc7395a5f1f6c2e275d1dc4ea0be0c745)): ?>
<?php $attributes = $__attributesOriginalc7395a5f1f6c2e275d1dc4ea0be0c745; ?>
<?php unset($__attributesOriginalc7395a5f1f6c2e275d1dc4ea0be0c745); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc7395a5f1f6c2e275d1dc4ea0be0c745)): ?>
<?php $component = $__componentOriginalc7395a5f1f6c2e275d1dc4ea0be0c745; ?>
<?php unset($__componentOriginalc7395a5f1f6c2e275d1dc4ea0be0c745); ?>
<?php endif; ?>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginala467913f9ff34913553be64599ec6e92)): ?>
<?php $attributes = $__attributesOriginala467913f9ff34913553be64599ec6e92; ?>
<?php unset($__attributesOriginala467913f9ff34913553be64599ec6e92); ?>
<?php endif; ?>
<?php if (isset($__componentOriginala467913f9ff34913553be64599ec6e92)): ?>
<?php $component = $__componentOriginala467913f9ff34913553be64599ec6e92; ?>
<?php unset($__componentOriginala467913f9ff34913553be64599ec6e92); ?>
<?php endif; ?>
        <?php if (isset($component)) { $__componentOriginala467913f9ff34913553be64599ec6e92 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala467913f9ff34913553be64599ec6e92 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'e60dd9d2c3a62d619c9acb38f20d5aa5::select.index','data' => ['variant' => 'listbox','searchable' => true,'clearable' => true,'wire:model.live' => 'locationId','placeholder' => 'Todas las ubicaciones']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('flux::select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['variant' => 'listbox','searchable' => true,'clearable' => true,'wire:model.live' => 'locationId','placeholder' => 'Todas las ubicaciones']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__currentLoopData = $this->locations; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $location): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                <?php if (isset($component)) { $__componentOriginalc7395a5f1f6c2e275d1dc4ea0be0c745 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc7395a5f1f6c2e275d1dc4ea0be0c745 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'e60dd9d2c3a62d619c9acb38f20d5aa5::select.option.index','data' => ['value' => ''.e($location->id).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('flux::select.option'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['value' => ''.e($location->id).'']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>
<?php echo e($location->name); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc7395a5f1f6c2e275d1dc4ea0be0c745)): ?>
<?php $attributes = $__attributesOriginalc7395a5f1f6c2e275d1dc4ea0be0c745; ?>
<?php unset($__attributesOriginalc7395a5f1f6c2e275d1dc4ea0be0c745); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc7395a5f1f6c2e275d1dc4ea0be0c745)): ?>
<?php $component = $__componentOriginalc7395a5f1f6c2e275d1dc4ea0be0c745; ?>
<?php unset($__componentOriginalc7395a5f1f6c2e275d1dc4ea0be0c745); ?>
<?php endif; ?>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginala467913f9ff34913553be64599ec6e92)): ?>
<?php $attributes = $__attributesOriginala467913f9ff34913553be64599ec6e92; ?>
<?php unset($__attributesOriginala467913f9ff34913553be64599ec6e92); ?>
<?php endif; ?>
<?php if (isset($__componentOriginala467913f9ff34913553be64599ec6e92)): ?>
<?php $component = $__componentOriginala467913f9ff34913553be64599ec6e92; ?>
<?php unset($__componentOriginala467913f9ff34913553be64599ec6e92); ?>
<?php endif; ?>
        <?php if (isset($component)) { $__componentOriginala467913f9ff34913553be64599ec6e92 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginala467913f9ff34913553be64599ec6e92 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'e60dd9d2c3a62d619c9acb38f20d5aa5::select.index','data' => ['wire:model.live' => 'status']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('flux::select'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:model.live' => 'status']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

            <?php if (isset($component)) { $__componentOriginalc7395a5f1f6c2e275d1dc4ea0be0c745 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc7395a5f1f6c2e275d1dc4ea0be0c745 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'e60dd9d2c3a62d619c9acb38f20d5aa5::select.option.index','data' => ['value' => 'all']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('flux::select.option'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['value' => 'all']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>
Todos los estados <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc7395a5f1f6c2e275d1dc4ea0be0c745)): ?>
<?php $attributes = $__attributesOriginalc7395a5f1f6c2e275d1dc4ea0be0c745; ?>
<?php unset($__attributesOriginalc7395a5f1f6c2e275d1dc4ea0be0c745); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc7395a5f1f6c2e275d1dc4ea0be0c745)): ?>
<?php $component = $__componentOriginalc7395a5f1f6c2e275d1dc4ea0be0c745; ?>
<?php unset($__componentOriginalc7395a5f1f6c2e275d1dc4ea0be0c745); ?>
<?php endif; ?>
            <?php if (isset($component)) { $__componentOriginalc7395a5f1f6c2e275d1dc4ea0be0c745 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc7395a5f1f6c2e275d1dc4ea0be0c745 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'e60dd9d2c3a62d619c9acb38f20d5aa5::select.option.index','data' => ['value' => 'draft']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('flux::select.option'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['value' => 'draft']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>
Borrador <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc7395a5f1f6c2e275d1dc4ea0be0c745)): ?>
<?php $attributes = $__attributesOriginalc7395a5f1f6c2e275d1dc4ea0be0c745; ?>
<?php unset($__attributesOriginalc7395a5f1f6c2e275d1dc4ea0be0c745); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc7395a5f1f6c2e275d1dc4ea0be0c745)): ?>
<?php $component = $__componentOriginalc7395a5f1f6c2e275d1dc4ea0be0c745; ?>
<?php unset($__componentOriginalc7395a5f1f6c2e275d1dc4ea0be0c745); ?>
<?php endif; ?>
            <?php if (isset($component)) { $__componentOriginalc7395a5f1f6c2e275d1dc4ea0be0c745 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc7395a5f1f6c2e275d1dc4ea0be0c745 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'e60dd9d2c3a62d619c9acb38f20d5aa5::select.option.index','data' => ['value' => 'scheduled']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('flux::select.option'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['value' => 'scheduled']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>
Programada <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc7395a5f1f6c2e275d1dc4ea0be0c745)): ?>
<?php $attributes = $__attributesOriginalc7395a5f1f6c2e275d1dc4ea0be0c745; ?>
<?php unset($__attributesOriginalc7395a5f1f6c2e275d1dc4ea0be0c745); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc7395a5f1f6c2e275d1dc4ea0be0c745)): ?>
<?php $component = $__componentOriginalc7395a5f1f6c2e275d1dc4ea0be0c745; ?>
<?php unset($__componentOriginalc7395a5f1f6c2e275d1dc4ea0be0c745); ?>
<?php endif; ?>
            <?php if (isset($component)) { $__componentOriginalc7395a5f1f6c2e275d1dc4ea0be0c745 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc7395a5f1f6c2e275d1dc4ea0be0c745 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'e60dd9d2c3a62d619c9acb38f20d5aa5::select.option.index','data' => ['value' => 'published']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('flux::select.option'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['value' => 'published']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>
Publicada <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc7395a5f1f6c2e275d1dc4ea0be0c745)): ?>
<?php $attributes = $__attributesOriginalc7395a5f1f6c2e275d1dc4ea0be0c745; ?>
<?php unset($__attributesOriginalc7395a5f1f6c2e275d1dc4ea0be0c745); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc7395a5f1f6c2e275d1dc4ea0be0c745)): ?>
<?php $component = $__componentOriginalc7395a5f1f6c2e275d1dc4ea0be0c745; ?>
<?php unset($__componentOriginalc7395a5f1f6c2e275d1dc4ea0be0c745); ?>
<?php endif; ?>
         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginala467913f9ff34913553be64599ec6e92)): ?>
<?php $attributes = $__attributesOriginala467913f9ff34913553be64599ec6e92; ?>
<?php unset($__attributesOriginala467913f9ff34913553be64599ec6e92); ?>
<?php endif; ?>
<?php if (isset($__componentOriginala467913f9ff34913553be64599ec6e92)): ?>
<?php $component = $__componentOriginala467913f9ff34913553be64599ec6e92; ?>
<?php unset($__componentOriginala467913f9ff34913553be64599ec6e92); ?>
<?php endif; ?>
    </div>

    <?php if (isset($component)) { $__componentOriginal0a72bb2009468dece2d4608a050e87ba = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0a72bb2009468dece2d4608a050e87ba = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'e60dd9d2c3a62d619c9acb38f20d5aa5::table.index','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('flux::table'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

        <?php if (isset($component)) { $__componentOriginal3f77032fa33cb52b5796e07e933bec29 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal3f77032fa33cb52b5796e07e933bec29 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'e60dd9d2c3a62d619c9acb38f20d5aa5::table.columns','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('flux::table.columns'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

            <?php if (isset($component)) { $__componentOriginal5c727a82f5e7858d0ad7f1030e4c25e8 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5c727a82f5e7858d0ad7f1030e4c25e8 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'e60dd9d2c3a62d619c9acb38f20d5aa5::table.column','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('flux::table.column'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>
URL <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5c727a82f5e7858d0ad7f1030e4c25e8)): ?>
<?php $attributes = $__attributesOriginal5c727a82f5e7858d0ad7f1030e4c25e8; ?>
<?php unset($__attributesOriginal5c727a82f5e7858d0ad7f1030e4c25e8); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5c727a82f5e7858d0ad7f1030e4c25e8)): ?>
<?php $component = $__componentOriginal5c727a82f5e7858d0ad7f1030e4c25e8; ?>
<?php unset($__componentOriginal5c727a82f5e7858d0ad7f1030e4c25e8); ?>
<?php endif; ?>
            <?php if (isset($component)) { $__componentOriginal5c727a82f5e7858d0ad7f1030e4c25e8 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5c727a82f5e7858d0ad7f1030e4c25e8 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'e60dd9d2c3a62d619c9acb38f20d5aa5::table.column','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('flux::table.column'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>
Categoría <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5c727a82f5e7858d0ad7f1030e4c25e8)): ?>
<?php $attributes = $__attributesOriginal5c727a82f5e7858d0ad7f1030e4c25e8; ?>
<?php unset($__attributesOriginal5c727a82f5e7858d0ad7f1030e4c25e8); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5c727a82f5e7858d0ad7f1030e4c25e8)): ?>
<?php $component = $__componentOriginal5c727a82f5e7858d0ad7f1030e4c25e8; ?>
<?php unset($__componentOriginal5c727a82f5e7858d0ad7f1030e4c25e8); ?>
<?php endif; ?>
            <?php if (isset($component)) { $__componentOriginal5c727a82f5e7858d0ad7f1030e4c25e8 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5c727a82f5e7858d0ad7f1030e4c25e8 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'e60dd9d2c3a62d619c9acb38f20d5aa5::table.column','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('flux::table.column'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>
Ubicación <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5c727a82f5e7858d0ad7f1030e4c25e8)): ?>
<?php $attributes = $__attributesOriginal5c727a82f5e7858d0ad7f1030e4c25e8; ?>
<?php unset($__attributesOriginal5c727a82f5e7858d0ad7f1030e4c25e8); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5c727a82f5e7858d0ad7f1030e4c25e8)): ?>
<?php $component = $__componentOriginal5c727a82f5e7858d0ad7f1030e4c25e8; ?>
<?php unset($__componentOriginal5c727a82f5e7858d0ad7f1030e4c25e8); ?>
<?php endif; ?>
            <?php if (isset($component)) { $__componentOriginal5c727a82f5e7858d0ad7f1030e4c25e8 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5c727a82f5e7858d0ad7f1030e4c25e8 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'e60dd9d2c3a62d619c9acb38f20d5aa5::table.column','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('flux::table.column'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>
Estado <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5c727a82f5e7858d0ad7f1030e4c25e8)): ?>
<?php $attributes = $__attributesOriginal5c727a82f5e7858d0ad7f1030e4c25e8; ?>
<?php unset($__attributesOriginal5c727a82f5e7858d0ad7f1030e4c25e8); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5c727a82f5e7858d0ad7f1030e4c25e8)): ?>
<?php $component = $__componentOriginal5c727a82f5e7858d0ad7f1030e4c25e8; ?>
<?php unset($__componentOriginal5c727a82f5e7858d0ad7f1030e4c25e8); ?>
<?php endif; ?>
            <?php if (isset($component)) { $__componentOriginal5c727a82f5e7858d0ad7f1030e4c25e8 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal5c727a82f5e7858d0ad7f1030e4c25e8 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'e60dd9d2c3a62d619c9acb38f20d5aa5::table.column','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('flux::table.column'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>
Acciones <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal5c727a82f5e7858d0ad7f1030e4c25e8)): ?>
<?php $attributes = $__attributesOriginal5c727a82f5e7858d0ad7f1030e4c25e8; ?>
<?php unset($__attributesOriginal5c727a82f5e7858d0ad7f1030e4c25e8); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal5c727a82f5e7858d0ad7f1030e4c25e8)): ?>
<?php $component = $__componentOriginal5c727a82f5e7858d0ad7f1030e4c25e8; ?>
<?php unset($__componentOriginal5c727a82f5e7858d0ad7f1030e4c25e8); ?>
<?php endif; ?>
         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal3f77032fa33cb52b5796e07e933bec29)): ?>
<?php $attributes = $__attributesOriginal3f77032fa33cb52b5796e07e933bec29; ?>
<?php unset($__attributesOriginal3f77032fa33cb52b5796e07e933bec29); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal3f77032fa33cb52b5796e07e933bec29)): ?>
<?php $component = $__componentOriginal3f77032fa33cb52b5796e07e933bec29; ?>
<?php unset($__componentOriginal3f77032fa33cb52b5796e07e933bec29); ?>
<?php endif; ?>
        <?php if (isset($component)) { $__componentOriginal85e16a75e372f4e3a67a9194622e1c8c = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal85e16a75e372f4e3a67a9194622e1c8c = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'e60dd9d2c3a62d619c9acb38f20d5aa5::table.rows','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('flux::table.rows'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::openLoop(); ?><?php endif; ?><?php $__empty_1 = true; $__currentLoopData = $this->landings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $landing): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::startLoopIteration(); ?><?php endif; ?>
                <?php if (isset($component)) { $__componentOriginal2133c30832e0f094522523cf64171420 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal2133c30832e0f094522523cf64171420 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'e60dd9d2c3a62d619c9acb38f20d5aa5::table.row','data' => ['wire:key' => 'landing-'.e($landing->id).'']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('flux::table.row'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:key' => 'landing-'.e($landing->id).'']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

                    <?php if (isset($component)) { $__componentOriginal57d943fde8fc41daddcb4b24245801cc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal57d943fde8fc41daddcb4b24245801cc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'e60dd9d2c3a62d619c9acb38f20d5aa5::table.cell','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('flux::table.cell'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

                        <a href="<?php echo e(url('/'.$landing->slug)); ?>" target="_blank" class="text-blue-600 hover:underline">
                            /<?php echo e($landing->slug); ?>

                        </a>
                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal57d943fde8fc41daddcb4b24245801cc)): ?>
<?php $attributes = $__attributesOriginal57d943fde8fc41daddcb4b24245801cc; ?>
<?php unset($__attributesOriginal57d943fde8fc41daddcb4b24245801cc); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal57d943fde8fc41daddcb4b24245801cc)): ?>
<?php $component = $__componentOriginal57d943fde8fc41daddcb4b24245801cc; ?>
<?php unset($__componentOriginal57d943fde8fc41daddcb4b24245801cc); ?>
<?php endif; ?>
                    <?php if (isset($component)) { $__componentOriginal57d943fde8fc41daddcb4b24245801cc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal57d943fde8fc41daddcb4b24245801cc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'e60dd9d2c3a62d619c9acb38f20d5aa5::table.cell','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('flux::table.cell'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>
<?php echo e($landing->category?->name ?? '—'); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal57d943fde8fc41daddcb4b24245801cc)): ?>
<?php $attributes = $__attributesOriginal57d943fde8fc41daddcb4b24245801cc; ?>
<?php unset($__attributesOriginal57d943fde8fc41daddcb4b24245801cc); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal57d943fde8fc41daddcb4b24245801cc)): ?>
<?php $component = $__componentOriginal57d943fde8fc41daddcb4b24245801cc; ?>
<?php unset($__componentOriginal57d943fde8fc41daddcb4b24245801cc); ?>
<?php endif; ?>
                    <?php if (isset($component)) { $__componentOriginal57d943fde8fc41daddcb4b24245801cc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal57d943fde8fc41daddcb4b24245801cc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'e60dd9d2c3a62d619c9acb38f20d5aa5::table.cell','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('flux::table.cell'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>
<?php echo e($landing->location?->name ?? 'sólo categoría'); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal57d943fde8fc41daddcb4b24245801cc)): ?>
<?php $attributes = $__attributesOriginal57d943fde8fc41daddcb4b24245801cc; ?>
<?php unset($__attributesOriginal57d943fde8fc41daddcb4b24245801cc); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal57d943fde8fc41daddcb4b24245801cc)): ?>
<?php $component = $__componentOriginal57d943fde8fc41daddcb4b24245801cc; ?>
<?php unset($__componentOriginal57d943fde8fc41daddcb4b24245801cc); ?>
<?php endif; ?>
                    <?php if (isset($component)) { $__componentOriginal57d943fde8fc41daddcb4b24245801cc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal57d943fde8fc41daddcb4b24245801cc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'e60dd9d2c3a62d619c9acb38f20d5aa5::table.cell','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('flux::table.cell'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

                        <?php if (isset($component)) { $__componentOriginal4cc377eda9b63b796b6668ee7832d023 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal4cc377eda9b63b796b6668ee7832d023 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'e60dd9d2c3a62d619c9acb38f20d5aa5::badge.index','data' => ['color' => $landing->status->color(),'size' => 'sm']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('flux::badge'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['color' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute($landing->status->color()),'size' => 'sm']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>
<?php echo e($landing->status->label()); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal4cc377eda9b63b796b6668ee7832d023)): ?>
<?php $attributes = $__attributesOriginal4cc377eda9b63b796b6668ee7832d023; ?>
<?php unset($__attributesOriginal4cc377eda9b63b796b6668ee7832d023); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal4cc377eda9b63b796b6668ee7832d023)): ?>
<?php $component = $__componentOriginal4cc377eda9b63b796b6668ee7832d023; ?>
<?php unset($__componentOriginal4cc377eda9b63b796b6668ee7832d023); ?>
<?php endif; ?>
                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($landing->status === \App\Enums\LandingStatus::Scheduled && $landing->publish_at): ?>
                            <?php if (isset($component)) { $__componentOriginal0638ebfbd490c7a414275d493e14cb4e = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal0638ebfbd490c7a414275d493e14cb4e = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'e60dd9d2c3a62d619c9acb38f20d5aa5::text','data' => ['size' => 'sm','class' => 'mt-1 text-zinc-500']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('flux::text'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['size' => 'sm','class' => 'mt-1 text-zinc-500']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>
<?php echo e($landing->publish_at->format('d/m/Y')); ?> <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal0638ebfbd490c7a414275d493e14cb4e)): ?>
<?php $attributes = $__attributesOriginal0638ebfbd490c7a414275d493e14cb4e; ?>
<?php unset($__attributesOriginal0638ebfbd490c7a414275d493e14cb4e); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal0638ebfbd490c7a414275d493e14cb4e)): ?>
<?php $component = $__componentOriginal0638ebfbd490c7a414275d493e14cb4e; ?>
<?php unset($__componentOriginal0638ebfbd490c7a414275d493e14cb4e); ?>
<?php endif; ?>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal57d943fde8fc41daddcb4b24245801cc)): ?>
<?php $attributes = $__attributesOriginal57d943fde8fc41daddcb4b24245801cc; ?>
<?php unset($__attributesOriginal57d943fde8fc41daddcb4b24245801cc); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal57d943fde8fc41daddcb4b24245801cc)): ?>
<?php $component = $__componentOriginal57d943fde8fc41daddcb4b24245801cc; ?>
<?php unset($__componentOriginal57d943fde8fc41daddcb4b24245801cc); ?>
<?php endif; ?>
                    <?php if (isset($component)) { $__componentOriginal57d943fde8fc41daddcb4b24245801cc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal57d943fde8fc41daddcb4b24245801cc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'e60dd9d2c3a62d619c9acb38f20d5aa5::table.cell','data' => ['class' => 'flex gap-2']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('flux::table.cell'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['class' => 'flex gap-2']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

                        <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if BLOCK]><![endif]--><?php endif; ?><?php if($landing->status === \App\Enums\LandingStatus::Published): ?>
                            <?php if (isset($component)) { $__componentOriginalc04b147acd0e65cc1a77f86fb0e81580 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc04b147acd0e65cc1a77f86fb0e81580 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'e60dd9d2c3a62d619c9acb38f20d5aa5::button.index','data' => ['wire:click' => 'unpublish('.e($landing->id).')','size' => 'xs','variant' => 'ghost','icon' => 'eye-slash','title' => 'Despublicar']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('flux::button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:click' => 'unpublish('.e($landing->id).')','size' => 'xs','variant' => 'ghost','icon' => 'eye-slash','title' => 'Despublicar']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc04b147acd0e65cc1a77f86fb0e81580)): ?>
<?php $attributes = $__attributesOriginalc04b147acd0e65cc1a77f86fb0e81580; ?>
<?php unset($__attributesOriginalc04b147acd0e65cc1a77f86fb0e81580); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc04b147acd0e65cc1a77f86fb0e81580)): ?>
<?php $component = $__componentOriginalc04b147acd0e65cc1a77f86fb0e81580; ?>
<?php unset($__componentOriginalc04b147acd0e65cc1a77f86fb0e81580); ?>
<?php endif; ?>
                        <?php else: ?>
                            <?php if (isset($component)) { $__componentOriginalc04b147acd0e65cc1a77f86fb0e81580 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc04b147acd0e65cc1a77f86fb0e81580 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'e60dd9d2c3a62d619c9acb38f20d5aa5::button.index','data' => ['wire:click' => 'publishNow('.e($landing->id).')','size' => 'xs','variant' => 'ghost','icon' => 'rocket-launch','title' => 'Publicar ahora']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('flux::button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:click' => 'publishNow('.e($landing->id).')','size' => 'xs','variant' => 'ghost','icon' => 'rocket-launch','title' => 'Publicar ahora']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc04b147acd0e65cc1a77f86fb0e81580)): ?>
<?php $attributes = $__attributesOriginalc04b147acd0e65cc1a77f86fb0e81580; ?>
<?php unset($__attributesOriginalc04b147acd0e65cc1a77f86fb0e81580); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc04b147acd0e65cc1a77f86fb0e81580)): ?>
<?php $component = $__componentOriginalc04b147acd0e65cc1a77f86fb0e81580; ?>
<?php unset($__componentOriginalc04b147acd0e65cc1a77f86fb0e81580); ?>
<?php endif; ?>
                        <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
                        <?php if (isset($component)) { $__componentOriginalc04b147acd0e65cc1a77f86fb0e81580 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc04b147acd0e65cc1a77f86fb0e81580 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'e60dd9d2c3a62d619c9acb38f20d5aa5::button.index','data' => ['href' => route('admin.landings.edit', $landing),'size' => 'xs','variant' => 'ghost','icon' => 'pencil-square']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('flux::button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['href' => \Illuminate\View\Compilers\BladeCompiler::sanitizeComponentAttribute(route('admin.landings.edit', $landing)),'size' => 'xs','variant' => 'ghost','icon' => 'pencil-square']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc04b147acd0e65cc1a77f86fb0e81580)): ?>
<?php $attributes = $__attributesOriginalc04b147acd0e65cc1a77f86fb0e81580; ?>
<?php unset($__attributesOriginalc04b147acd0e65cc1a77f86fb0e81580); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc04b147acd0e65cc1a77f86fb0e81580)): ?>
<?php $component = $__componentOriginalc04b147acd0e65cc1a77f86fb0e81580; ?>
<?php unset($__componentOriginalc04b147acd0e65cc1a77f86fb0e81580); ?>
<?php endif; ?>
                        <?php if (isset($component)) { $__componentOriginalc04b147acd0e65cc1a77f86fb0e81580 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginalc04b147acd0e65cc1a77f86fb0e81580 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'e60dd9d2c3a62d619c9acb38f20d5aa5::button.index','data' => ['wire:click' => 'deleteLanding('.e($landing->id).')','wire:confirm' => '¿Eliminar la landing /'.e($landing->slug).'? La URL devolverá 404.','size' => 'xs','variant' => 'ghost','icon' => 'trash']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('flux::button'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['wire:click' => 'deleteLanding('.e($landing->id).')','wire:confirm' => '¿Eliminar la landing /'.e($landing->slug).'? La URL devolverá 404.','size' => 'xs','variant' => 'ghost','icon' => 'trash']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginalc04b147acd0e65cc1a77f86fb0e81580)): ?>
<?php $attributes = $__attributesOriginalc04b147acd0e65cc1a77f86fb0e81580; ?>
<?php unset($__attributesOriginalc04b147acd0e65cc1a77f86fb0e81580); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalc04b147acd0e65cc1a77f86fb0e81580)): ?>
<?php $component = $__componentOriginalc04b147acd0e65cc1a77f86fb0e81580; ?>
<?php unset($__componentOriginalc04b147acd0e65cc1a77f86fb0e81580); ?>
<?php endif; ?>
                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal57d943fde8fc41daddcb4b24245801cc)): ?>
<?php $attributes = $__attributesOriginal57d943fde8fc41daddcb4b24245801cc; ?>
<?php unset($__attributesOriginal57d943fde8fc41daddcb4b24245801cc); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal57d943fde8fc41daddcb4b24245801cc)): ?>
<?php $component = $__componentOriginal57d943fde8fc41daddcb4b24245801cc; ?>
<?php unset($__componentOriginal57d943fde8fc41daddcb4b24245801cc); ?>
<?php endif; ?>
                 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal2133c30832e0f094522523cf64171420)): ?>
<?php $attributes = $__attributesOriginal2133c30832e0f094522523cf64171420; ?>
<?php unset($__attributesOriginal2133c30832e0f094522523cf64171420); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal2133c30832e0f094522523cf64171420)): ?>
<?php $component = $__componentOriginal2133c30832e0f094522523cf64171420; ?>
<?php unset($__componentOriginal2133c30832e0f094522523cf64171420); ?>
<?php endif; ?>
            <?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::endLoop(); ?><?php endif; ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::closeLoop(); ?><?php endif; ?>
                <?php if (isset($component)) { $__componentOriginal2133c30832e0f094522523cf64171420 = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal2133c30832e0f094522523cf64171420 = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'e60dd9d2c3a62d619c9acb38f20d5aa5::table.row','data' => []] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('flux::table.row'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

                    <?php if (isset($component)) { $__componentOriginal57d943fde8fc41daddcb4b24245801cc = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal57d943fde8fc41daddcb4b24245801cc = $attributes; } ?>
<?php $component = Illuminate\View\AnonymousComponent::resolve(['view' => 'e60dd9d2c3a62d619c9acb38f20d5aa5::table.cell','data' => ['colspan' => '5','class' => 'text-center text-zinc-500']] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('flux::table.cell'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\Illuminate\View\AnonymousComponent::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes(['colspan' => '5','class' => 'text-center text-zinc-500']); ?>
<?php \Livewire\Features\SupportCompiledWireKeys\SupportCompiledWireKeys::processComponentKey($component); ?>

                        No hay landings con esos filtros.
                     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal57d943fde8fc41daddcb4b24245801cc)): ?>
<?php $attributes = $__attributesOriginal57d943fde8fc41daddcb4b24245801cc; ?>
<?php unset($__attributesOriginal57d943fde8fc41daddcb4b24245801cc); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal57d943fde8fc41daddcb4b24245801cc)): ?>
<?php $component = $__componentOriginal57d943fde8fc41daddcb4b24245801cc; ?>
<?php unset($__componentOriginal57d943fde8fc41daddcb4b24245801cc); ?>
<?php endif; ?>
                 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal2133c30832e0f094522523cf64171420)): ?>
<?php $attributes = $__attributesOriginal2133c30832e0f094522523cf64171420; ?>
<?php unset($__attributesOriginal2133c30832e0f094522523cf64171420); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal2133c30832e0f094522523cf64171420)): ?>
<?php $component = $__componentOriginal2133c30832e0f094522523cf64171420; ?>
<?php unset($__componentOriginal2133c30832e0f094522523cf64171420); ?>
<?php endif; ?>
            <?php endif; ?><?php if(\Livewire\Mechanisms\ExtendBlade\ExtendBlade::isRenderingLivewireComponent()): ?><!--[if ENDBLOCK]><![endif]--><?php endif; ?>
         <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal85e16a75e372f4e3a67a9194622e1c8c)): ?>
<?php $attributes = $__attributesOriginal85e16a75e372f4e3a67a9194622e1c8c; ?>
<?php unset($__attributesOriginal85e16a75e372f4e3a67a9194622e1c8c); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal85e16a75e372f4e3a67a9194622e1c8c)): ?>
<?php $component = $__componentOriginal85e16a75e372f4e3a67a9194622e1c8c; ?>
<?php unset($__componentOriginal85e16a75e372f4e3a67a9194622e1c8c); ?>
<?php endif; ?>
     <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal0a72bb2009468dece2d4608a050e87ba)): ?>
<?php $attributes = $__attributesOriginal0a72bb2009468dece2d4608a050e87ba; ?>
<?php unset($__attributesOriginal0a72bb2009468dece2d4608a050e87ba); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal0a72bb2009468dece2d4608a050e87ba)): ?>
<?php $component = $__componentOriginal0a72bb2009468dece2d4608a050e87ba; ?>
<?php unset($__componentOriginal0a72bb2009468dece2d4608a050e87ba); ?>
<?php endif; ?>

    <?php echo e($this->landings->links()); ?>

</div><?php /**PATH /home/cristian/proyectos/services-template/storage/framework/views/livewire/views/2a736f29.blade.php ENDPATH**/ ?>