@section('title')
Contact us
@stop

@section('content')
<h1>Contact US</h1>
<div class="container">
    <form method="POST" class="mx-auto px-10">

        <div class="form-group">
            <label for="name">Name</label>
            <input class="form-control" id="name" name="name" placeholder="Enter name">
        </div>

        <div class="form-group">
            <label for="message">Message</label>
            <textarea type="email" class="form-control" id="message" name="message" placeholder="Message here"></textarea>
        </div>

        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
@stop