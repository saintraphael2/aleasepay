<?php
    echo "<?php".PHP_EOL;
?>

namespace <?php echo e($config->namespaces->controller); ?>;

<?php if(config('laravel_generator.tables') === 'datatables'): ?>
use <?php echo e($config->namespaces->dataTables); ?>\<?php echo e($config->modelNames->name); ?>DataTable;
<?php endif; ?>
use <?php echo e($config->namespaces->request); ?>\Create<?php echo e($config->modelNames->name); ?>Request;
use <?php echo e($config->namespaces->request); ?>\Update<?php echo e($config->modelNames->name); ?>Request;
use <?php echo e($config->namespaces->app); ?>\Http\Controllers\AppBaseController;
use <?php echo e($config->namespaces->repository); ?>\<?php echo e($config->modelNames->name); ?>Repository;
use Illuminate\Http\Request;
use Flash;

class <?php echo e($config->modelNames->name); ?>Controller extends AppBaseController
{
    /** @var <?php echo e($config->modelNames->name); ?>Repository $<?php echo e($config->modelNames->camel); ?>Repository*/
    private $<?php echo e($config->modelNames->camel); ?>Repository;

    public function __construct(<?php echo e($config->modelNames->name); ?>Repository $<?php echo e($config->modelNames->camel); ?>Repo)
    {
        $this-><?php echo e($config->modelNames->camel); ?>Repository = $<?php echo e($config->modelNames->camel); ?>Repo;
    }

    /**
     * Display a listing of the <?php echo e($config->modelNames->name); ?>.
     */
    <?php echo $indexMethod; ?>


    /**
     * Show the form for creating a new <?php echo e($config->modelNames->name); ?>.
     */
    public function create()
    {
        return view('<?php echo e($config->prefixes->getViewPrefixForInclude()); ?><?php echo e($config->modelNames->snakePlural); ?>.create');
    }

    /**
     * Store a newly created <?php echo e($config->modelNames->name); ?> in storage.
     */
    public function store(Create<?php echo e($config->modelNames->name); ?>Request $request)
    {
        $input = $request->all();

        $<?php echo e($config->modelNames->camel); ?> = $this-><?php echo e($config->modelNames->camel); ?>Repository->create($input);

        <?php echo $__env->make('laravel-generator::scaffold.controller.messages.save_success', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        return redirect(route('<?php echo e($config->prefixes->getRoutePrefixWith('.')); ?><?php echo e($config->modelNames->camelPlural); ?>.index'));
    }

    /**
     * Display the specified <?php echo e($config->modelNames->name); ?>.
     */
    public function show($id)
    {
        $<?php echo e($config->modelNames->camel); ?> = $this-><?php echo e($config->modelNames->camel); ?>Repository->find($id);

        <?php echo $__env->make('laravel-generator::scaffold.controller.messages.not_found', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        return view('<?php echo e($config->prefixes->getViewPrefixForInclude()); ?><?php echo e($config->modelNames->snakePlural); ?>.show')->with('<?php echo e($config->modelNames->camel); ?>', $<?php echo e($config->modelNames->camel); ?>);
    }

    /**
     * Show the form for editing the specified <?php echo e($config->modelNames->name); ?>.
     */
    public function edit($id)
    {
        $<?php echo e($config->modelNames->camel); ?> = $this-><?php echo e($config->modelNames->camel); ?>Repository->find($id);

        <?php echo $__env->make('laravel-generator::scaffold.controller.messages.not_found', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        return view('<?php echo e($config->prefixes->getViewPrefixForInclude()); ?><?php echo e($config->modelNames->snakePlural); ?>.edit')->with('<?php echo e($config->modelNames->camel); ?>', $<?php echo e($config->modelNames->camel); ?>);
    }

    /**
     * Update the specified <?php echo e($config->modelNames->name); ?> in storage.
     */
    public function update($id, Update<?php echo e($config->modelNames->name); ?>Request $request)
    {
        $<?php echo e($config->modelNames->camel); ?> = $this-><?php echo e($config->modelNames->camel); ?>Repository->find($id);

        <?php echo $__env->make('laravel-generator::scaffold.controller.messages.not_found', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        $<?php echo e($config->modelNames->camel); ?> = $this-><?php echo e($config->modelNames->camel); ?>Repository->update($request->all(), $id);

        <?php echo $__env->make('laravel-generator::scaffold.controller.messages.update_success', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        return redirect(route('<?php echo e($config->prefixes->getRoutePrefixWith('.')); ?><?php echo e($config->modelNames->camelPlural); ?>.index'));
    }

    /**
     * Remove the specified <?php echo e($config->modelNames->name); ?> from storage.
     *
     * @throws \Exception
     */
    public function destroy($id)
    {
        $<?php echo e($config->modelNames->camel); ?> = $this-><?php echo e($config->modelNames->camel); ?>Repository->find($id);

        <?php echo $__env->make('laravel-generator::scaffold.controller.messages.not_found', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        $this-><?php echo e($config->modelNames->camel); ?>Repository->delete($id);

        <?php echo $__env->make('laravel-generator::scaffold.controller.messages.delete_success', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        return redirect(route('<?php echo e($config->prefixes->getRoutePrefixWith('.')); ?><?php echo e($config->modelNames->camelPlural); ?>.index'));
    }
}
<?php /**PATH D:\Dev\internetBanking\aleasepay2.0\resources\views/vendor/laravel-generator/scaffold/controller/controller_repository.blade.php ENDPATH**/ ?>