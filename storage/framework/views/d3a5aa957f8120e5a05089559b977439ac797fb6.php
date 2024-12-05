@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
<?php if($config->options->localized): ?>
                    <h1>@lang('models/<?php echo e($config->modelNames->camelPlural); ?>.plural')</h1>
<?php else: ?>
                    <h1><?php echo e($config->modelNames->humanPlural); ?></h1>
<?php endif; ?>
                </div>
                <div class="col-sm-6">
                    <a class="btn btn-primary float-right"
                       href="{{ route('<?php echo $config->prefixes->getRoutePrefixWith('.'); ?><?php echo $config->modelNames->camelPlural; ?>.create') }}">
<?php if($config->options->localized): ?>
                         @lang('crud.add_new')
<?php else: ?>
                        Add New
<?php endif; ?>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">

        @include('flash::message')

        <div class="clearfix"></div>

        <div class="card">
            <?php echo $table; ?>

        </div>
    </div>

@endsection
<?php /**PATH D:\Dev\internetBanking\aleasepay2.0\vendor\infyomlabs\adminlte-templates\src/../views/templates/scaffold/index.blade.php ENDPATH**/ ?>