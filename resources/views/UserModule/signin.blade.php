@extends('Templates.header')

@section('style')
    css/login.css
@endsection

<!--Article-->


<!--Style del article-->
@section('articleClass')
    d-flex flex-row justify-content-center align-items-center col-md-12
@endsection

<!--Contenido del article-->
@section('article')
    <section class="col-md-10">
        <article class="d-flex flex-row align-items-center justify-content-center col-md-12">
            <section class="Container-Left col-md-7">
                <img class="col-md-7" src="img/signin.svg" alt="Imagen de registro.">
                <h1 class="col-md-7">¡Tu mejor opción!</h1>
            </section>
            <section class="Container-Rigth col-md-6">
                <h2 class="col-md-12">¡Registrate!</h2>
                <form class="d-flex flex-column justify-content-between align-items-center col-md-12" action="">
                    <input class="form-control col-md-10" type="text" name="name" placeholder=" Nombre...">
                    <input class="form-control col-md-10" type="text" name="surname" placeholder=" Apellido...">
                    <input class="form-control col-md-10" type="email" name="email" placeholder=" Email...">
                    <input class="form-control col-md-10" type="password" name="password" placeholder=" Contraseña...">
                    <input class="form-control col-md-10" type="password" name="passwordConfirm" placeholder=" Confirmar contraseña...">
                    <input class="col-md-5" type="submit" value="Registrarme">
                    <br>
                </form>
            </section>
        </article>
    </section>
@endsection