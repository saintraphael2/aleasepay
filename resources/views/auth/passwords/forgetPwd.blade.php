<style>
.card {
    word-wrap: break-word;
    background-clip: border-box;
    background-color: #fff;
    border: 0 solid rgba(0, 0, 0, .125);
    border-radius: .25rem;
    display: flex;
    flex-direction: column;
    min-width: 0;
    position: relative;
    box-shadow: 0 0 1px rgba(0, 0, 0, .125), 0 1px 3px rgba(0, 0, 0, .2);
}
</style>
<div class="card logincardctz">
    <div class="card-body login-card-body">
        <h3>Mot de passe perdu</h3>
        <a href="{{ route('reset.password.get', $token) }}"> Cliquez ici pour réinitialiser votre mot de passe </a>
    </div>
</div>