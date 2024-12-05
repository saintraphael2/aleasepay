<?php
    echo "<?php".PHP_EOL;
?>

namespace <?php echo e($config->namespaces->model); ?>;

use Illuminate\Database\Eloquent\Model;
<?php if($config->options->softDelete): ?> <?php echo e('use Illuminate\Database\Eloquent\SoftDeletes;'); ?><?php endif; ?>
<?php if($config->options->tests or $config->options->factory): ?> <?php echo e('use Illuminate\Database\Eloquent\Factories\HasFactory;'); ?><?php endif; ?>

<?php if(isset($swaggerDocs)): ?><?php echo $swaggerDocs; ?><?php endif; ?>
class <?php echo e($config->modelNames->name); ?> extends Model
{
<?php if($config->options->softDelete): ?> <?php echo e(infy_tab().'use SoftDeletes;'); ?><?php endif; ?>
<?php if($config->options->tests or $config->options->factory): ?><?php echo e(infy_tab().'use HasFactory;'); ?><?php endif; ?>
    public $table = '<?php echo e($config->tableName); ?>';

<?php if($customPrimaryKey): ?><?php echo infy_tab() ?>protected $primaryKey = '<?php echo e($customPrimaryKey); ?>';<?php echo infy_nls(2) ?><?php endif; ?>
<?php if($config->connection): ?><?php echo infy_tab() ?>protected $connection = '<?php echo e($config->connection); ?>';<?php echo infy_nls(2) ?><?php endif; ?>
<?php if(!$timestamps): ?><?php echo infy_tab() ?>public $timestamps = false;<?php echo infy_nls(2) ?><?php endif; ?>
<?php if($customSoftDelete): ?><?php echo infy_tab() ?>protected $dates = ['<?php echo e($customSoftDelete); ?>'];<?php echo infy_nls(2) ?><?php endif; ?>
<?php if($customCreatedAt): ?><?php echo infy_tab() ?>const CREATED_AT = '<?php echo e($customCreatedAt); ?>';<?php echo infy_nls(2) ?><?php endif; ?>
<?php if($customUpdatedAt): ?><?php echo infy_tab() ?>const UPDATED_AT = '<?php echo e($customUpdatedAt); ?>';<?php echo infy_nls(2) ?><?php endif; ?>
    public $fillable = [
        <?php echo $fillables; ?>

    ];

    protected $casts = [
        <?php echo $casts; ?>

    ];

    public static array $rules = [
        <?php echo $rules; ?>

    ];

    <?php echo $relations; ?>

}
<?php /**PATH D:\Dev\internetBanking\aleasepay2.0\resources\views/vendor/laravel-generator/model/model.blade.php ENDPATH**/ ?>