@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">News Verifier</div>

                <div class="panel-body">
                    <div id="body">
                        <form class="form-horizontal" method="POST" id="fake_news">
                            {{ csrf_field() }}

                            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                <label for="name" class="col-md-4 control-label">Author</label>

                                <div class="col-md-6">
                                    <input type="text" name="name" id="name" class="form-control" placeholder="Author..."/>
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('location') ? ' has-error' : '' }}">
                                <label for="location" class="col-md-4 control-label">Location</label>

                                <div class="col-md-6">
                                    <input type="text" class="form-control" id="location" name="location" placeholder="Location..."/>
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('headline') ? ' has-error' : '' }}">
                                <label for="headline" class="col-md-4 control-label">News Status</label>

                                <div class="col-md-6">
                                    <textarea name="headline" class="form-control" id="headline" cols="30" rows="4" placeholder="Post news..."></textarea>

                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-6 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary">
                                        Post
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div id="loader" style="text-align: center;display: none;font-size: 20px">
                        <img src="{{asset('img/loader.gif')}}" alt="loader" style="margin: auto;display: block">
                        Verifying news...
                    </div>
                    <table class="table table-responsive" id="news_table">
                        <tbody id="news_details">

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<script>
$(document).ready(function () {

    var news = [];

    $("#fake_news").submit(function (e) {

        e.preventDefault();

        $("#loader").show();
        $("#body").hide();

        const author = $("#name").val();
        const headline = $("#headline").val();
        const location = $("#location").val();
        // const description = $("#description").val();

        var data = {
            _token : $("input[name=_token]").val(),
            headline    : headline,
            name    : author,
            location    : location
        };


        // Price Bar ...
        $.post("/api/v1/verifier", data,function (data) {
            console.log(data);
            if (data['fake'] === true) {
                swal("Fake News!", "Not posted.", "error");
            }else if(data['fake'] === false) {
                //swal("News posted!", "1st phase success.", "success");
                console.log(data['news']);
                $(this).renderNewsList(data['news']);
                $("#loader").hide();
                $("#body").hide();
            }else {
                swal("Failed!", "To post data", "error");
            }
        }).done(function () {
            $("#loader").hide();
            $("#body").show();
            $("#headline").val("");
            $("#description").val("");
        });

        $.fn.renderNewsList = function(data){
            $.each(data, function (index, news) {
                //total += parseInt(news.price);
                $("#news_details").append(
                    $("<tr>").append(
                        $("<td>", {html: "<img src='" + news.urlToImage + "' width='100%'/>"})
                    ),
                    $("<tr>").append(
                        $("<td>", {html: "<h2><b>" + news.title + "</b></h2>"})
                    ),
                    $("<tr>").append(
                        $("<td>", {text: news.description})
                    ),
                    $("<tr>").append(
                        $("<td>", {text: news.content})
                    ),
                    $("<tr>").append(
                        $("<td>", {text: news.publishedAt})
                    )
                )
            });
        };
    });
});
</script>
@endsection
