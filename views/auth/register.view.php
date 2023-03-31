@section('title')
Register
@stop

@section('content')
<form method="POST">

    <?php if (session()->hasErrors()) { ?>
        <div class="alert alert-primary" role="alert">
            <?php foreach (session()->getErrors() as $errors) { ?>
                <?php foreach ($errors as $error) { ?>
                    - <?= $error ?> <br>
                <?php } ?>
            <?php } ?>
        </div>
    <?php } ?>

    <?php if (!empty(session()->getFlash('message'))) { ?>
        <div class="alert alert-<?= session()->getFlash('class') ?>" role="alert">
            <?= session()->getFlash('message') ?>
        </div>
    <?php } ?>

    <div class="form-group">
        <label for="name">Name</label>
        <input class="form-control" id="name" name="name" placeholder="Enter name">
    </div>
    <div class="form-group">
        <label for="exampleInputEmail1">Email address</label>
        <input type="email" name="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Enter email">
    </div>
    <div class="form-group">
        <label for="exampleInputPassword1">Password</label>
        <input type="password" name="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
    </div>

    <button type="submit" class="btn btn-primary my-4">Submit</button>
</form>
@stop