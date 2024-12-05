{!! Form::open(['route' => ['bordereaux.destroy', $id], 'method' => 'delete']) !!}
<div class='btn-group'>
    
    <a href="{{ route('bordereaux.edit', $id) }}" class='btn btn-default btn-xs'>
        <i class="fa fa-edit"></i>
    </a>
    {!! Form::button('<i class="fa fa-trash"></i>', [
        'type' => 'submit',
        'class' => 'btn btn-danger btn-xs',
        'onclick' => 'return confirm("Êtes vous sûr de supprimer la commande?")'

    ]) !!}
</div>
{!! Form::close() !!}
