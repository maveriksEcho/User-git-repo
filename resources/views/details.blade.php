@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">

                @isset ($repos[0]['owner']['avatar_url'])
                        <img src="{{$repos[0]['owner']['avatar_url']}}" alt="avatar" style="width: 200px; height: 200px; margin-bottom: 20px">
                @endisset
                        <h2>Repository details</h2>
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th scope="col">Name</th>
                                <th scope="col">Value</th>
                            </tr>
                            </thead>
                            <tbody>
                            @if ($repo)
                            <tr>
                                <th scope="row">Id</th>
                                <td>{{ $repo['id']}}</td>
                            </tr>
                            <tr>
                                <th scope="row">Name</th>
                                <td>{{ $repo['name']}}</td>
                            </tr>
                            <tr>
                                <th scope="row">Likes</th>
                                <td>{{ $repo['like']}}</td>
                            </tr>
                            <tr>
                                <th scope="row">Dislikes</th>
                                <td>{{ $repo['dislike']}}</td>
                            </tr>
                            <tr>
                                <th scope="row">Watch</th>
                                <td>{{ $repo['watchers_count']}}</td>
                            </tr>
                            <tr>
                                <th scope="row">Star</th>
                                <td>{{ $repo['stargazers_count']}}</td>
                            </tr>
                            <tr>
                                <th scope="row">Fork</th>
                                <td>{{ $repo['forks']}}</td>
                            </tr>
                            <tr>
                                <th scope="row">Owner login </th>
                                <td>{{ $repo['owner']['login']}}</td>
                            </tr>
                            <tr>
                                <th scope="row">Url</th>
                                <td><a href="{{ $repo['owner']['url']}}"></a>{{ $repo['owner']['url']}}</td>
                            </tr>
                            <tr>
                                <th scope="row">Description</th>
                                <td>{{ $repo['description']}}</td>
                            </tr>
                            <tr>
                                <th scope="row">Language</th>
                                <td>{{ $repo['language']}}</td>
                            </tr>
                             @endif
                            </tbody>
                        </table>
                </div>
</div>
@endsection
