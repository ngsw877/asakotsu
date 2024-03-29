@extends('app')

@section('title', 'プロフィール編集')

@include('nav')

@section('content')
    <div class="container my-5">
        <div class="row">
            <div class="card mx-auto col-md-7">
                <h2 class="h4 card-header text-center sunny-morning-gradient text-white">プロフィール編集</h2>
                <div class="card-body">

                    @include('error_card_list')

                    <div class="user-form my-4">
                        <form method="POST" action="{{ route('users.update', ['name' => $user->name]) }}"
                              enctype="multipart/form-data">
                            @method('PATCH')
                            @csrf
                            <div class="form-group text-center">
                                <label for="profile_image">
                                    <p class="mb-1">プロフィール画像</p>
                                    <img class="profile-icon image-upload rounded-circle"
                                         src="{{ $user->profile_image }}" alt="プロフィールアイコン">
                                    @if (Auth::id() != config('user.guest_user_id'))
                                        <input type="file" name="profile_image" id="profile_image" class="d-none"
                                               accept="image/*">
                                    @endif
                                </label>
                            </div>
                            @if (Auth::id() == config('user.guest_user.id'))
                                <p class="text-danger">
                                    <b>※ゲストユーザーは、以下を編集できません。</b><br>
                                    ・アイコン画像<br>
                                    ・ユーザー名<br>
                                    ・メールアドレス<br>
                                </p>
                            @endif
                            <div class="form-group">
                                <label for="name">
                                    ユーザー名
                                    <small class="blue-grey-text">（15文字以内）</small>
                                </label>
                                @if (Auth::id() == config('user.guest_user.id'))
                                    <input class="form-control" type="text" id="name" name="name"
                                           value="{{ $user->name }}" readonly>
                                @else
                                    <input class="form-control" type="text" id="name" name="name"
                                           value="{{ $user->name ?? old('name') }}">
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="email">メールアドレス</label>
                                @if (Auth::id() == config('user.guest_user.id'))
                                    <input class="form-control" type="text" id="email" name="email"
                                           value="{{ $user->email }}" readonly>
                                @else
                                    <input class="form-control" type="text" id="email" name="email"
                                           value="{{ $user->email ?? old('email') }}">
                                @endif
                            </div>
                            <div class="form-group">
                                <label for="wake_up_time">
                                    目標起床時間
                                    <small class="blue-grey-text">（04:00 〜 10:00）</small>
                                    <p class="mb-1 small text-default">※動作確認用に、現在自由に目標起床時間を設定できます。</p>
                                </label>
                                <!-- 動作確認用に、目標起床時間の設定可能時間帯の制限を解除中。　min="04:00" max="10:00" -->
                                <input class="form-control" type="time" id="wake_up_time" name="wake_up_time"
                                       value="{{
                    null !== old('wake_up_time') ?
                    Carbon\Carbon::parse(old('wake_up_time'))->format('H:i') :
                    $user->wake_up_time->format('H:i')
                  }}">
                            </div>
                            <div class="form-group">
                                <label for="email">
                                    自己紹介文
                                    <small class="blue-grey-text">（200文字以内）</small>
                                </label>
                                <textarea name="self_introduction" class="form-control"
                                          rows="8">{{ $user->self_introduction ?? old('self_introduction') }}</textarea>
                            </div>
                            <div>
                                <a href="{{ route('users.edit_password', ['name' => $user->name]) }}">
                                    パスワード変更はこちら
                                </a>
                            </div>
                            <div class="d-flex justify-content-between">
                                <button class="btn peach-gradient mt-2 mb-2 w-50 mx-auto" type="submit">
                                    <span class="h6">保存</span>
                                </button>
                            </div>

                        </form>

                    @if(Auth::id() != config('user.guest_user.id'))
                        <!-- dropdown -->
                            <div class="d-flex justify-content-between">
                                <button class="dropdown-item btn blue-gradient mt-2 mb-2 w-50 mx-auto text-center"
                                        data-toggle="modal"
                                        data-target="#modal-delete-{{ $user->id }}"
                                >
                                    <span class="h6">退会</span>
                                </button>
                            </div>
                            <!-- dropdown -->

                            <!-- modal -->
                            @include('components.confirm_modal',
                             [
                              'id' => 'modal-delete-' . $user->id,
                              'action' => route('users.destroy', ['name' => $user->name]),
                              'method' => 'DELETE',
                              'yesText' => '退会する',
                              'message' => 'アカウントを削除します。よろしいですか？',
                             ])
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
