@extends('layouts.app')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-12">
                    <h1>
<?php if($config->options->localized): ?>
                        @lang('crud.edit') @lang('models/<?php echo $config->modelNames->camelPlural; ?>.singular')
<?php else: ?>
                        Edit <?php echo e($config->modelNames->human); ?>

<?php endif; ?>
                    </h1>
                </div>
            </div>
        </div>
    </section>

    <div class="content px-3">

        @include('adminlte-templates::common.errors')

        <div class="card">

            {!! Form::model($<?php echo e($config->modelNames->camel); ?>, ['route' => ['<?php echo e($config->prefixes->getRoutePrefixWith('.')); ?><?php echo e($config->modelNames->camelPlural); ?>.update', $<?php echo e($config->modelNames->camel); ?>-><?php echo e($config->primaryName); ?>], 'method' => 'patch']) !!}

            <div class="card-body">
                <div class="row">
                    @include('<?php echo e($config->prefixes->getViewPrefixForInclude()); ?><?php echo e($config->modelNames->snakePlural); ?>.fields')
                </div>
            </div>

            <div class="card-footer">
                {!! Form::submit('Save', ['class' => 'btn btn-primary']) !!}
                <a href="{{ route('<?php echo $config->prefixes->getRoutePrefixWith('.'); ?><?php echo $config->modelNames->camelPlural; ?>.index') }}" class="btn btn-default"><?php if($config->options->localized): ?> @lang('crud.cancel') <?php else: ?> Cancel <?php endif; ?></a>
            </div>

            {!! Form::close() !!}

        </div>
    </div>
@endsection
<?php /**PATH D:\Dev\internetBanking\aleasepay2.0\vendor\infyomlabs\adminlte-templates\src/../views/templates/scaffold/edit.blade.php ENDPATH**/ ?>