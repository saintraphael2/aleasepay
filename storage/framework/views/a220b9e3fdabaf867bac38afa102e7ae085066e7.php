<?php
    echo "<?php".PHP_EOL;
?>

namespace <?php echo e($config->namespaces->request); ?>;

use <?php echo e($config->namespaces->model); ?>\<?php echo e($config->modelNames->name); ?>;
use Illuminate\Foundation\Http\FormRequest;

class Update<?php echo e($config->modelNames->name); ?>Request extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules = <?php echo e($config->modelNames->name); ?>::$rules;
        <?php echo $uniqueRules; ?>

        return $rules;
    }
}
<?php /**PATH D:\Dev\internetBanking\aleasepay2.0\resources\views/vendor/laravel-generator/scaffold/request/update.blade.php ENDPATH**/ ?>