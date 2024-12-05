@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>
<?php if($config->options->localized): ?>
                        <?php echo e($config->modelNames->human); ?> Details
<?php else: ?>
                    @lang('models/<?php echo $config->modelNames->camelPlural; ?>.singular') @lang('crud.detail')
<?php endif; ?>
                    </h1>
                </div>
                <div class="col-sm-6">
                    <a class="btn btn-default float-right"
                       href="{{ route('<?php echo $config->prefixes->getRoutePrefixWith('.'); ?><?php echo $config->modelNames->camelPlural; ?>.index') }}">
                        <?php if($config->options->localized): ?>
                            Back
                        <?php else: ?>
                            @lang('crud.back')
                        <?php endif; ?>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    @include('<?php echo e($config->prefixes->getViewPrefixForInclude()); ?><?php echo e($config->modelNames->snakePlural); ?>.show_fields')
                </div>
            </div>
        </div>
    </div>
@endsection
<?php /**PATH D:\Dev\internetBanking\aleasepay2.0\vendor\infyomlabs\adminlte-templates\src/../views/templates/scaffold/show.blade.php ENDPATH**/ ?>