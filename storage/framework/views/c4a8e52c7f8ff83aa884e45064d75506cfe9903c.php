<?php
    echo "<?php".PHP_EOL;
?>

namespace <?php echo e($config->namespaces->repository); ?>;

use <?php echo e($config->namespaces->model); ?>\<?php echo e($config->modelNames->name); ?>;
use <?php echo e($config->namespaces->app); ?>\Repositories\BaseRepository;

class <?php echo e($config->modelNames->name); ?>Repository extends BaseRepository
{
    protected $fieldSearchable = [
        <?php echo $fieldSearchable; ?>

    ];

    public function getFieldsSearchable(): array
    {
        return $this->fieldSearchable;
    }

    public function model(): string
    {
        return <?php echo e($config->modelNames->name); ?>::class;
    }
}
<?php /**PATH D:\Dev\internetBanking\aleasepay2.0\resources\views/vendor/laravel-generator/repository/repository.blade.php ENDPATH**/ ?>