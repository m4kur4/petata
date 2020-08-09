<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('_static/css/petata-proto.css') }}">

    <!-- vendor -->
    <link href="https://unpkg.com/material-components-web@latest/dist/material-components-web.min.css" rel="stylesheet">
    <script src="https://unpkg.com/material-components-web@latest/dist/material-components-web.min.js"></script>

    <title>Petata</title>
</head>
<body>
    <header class="header mdc-elevation--z2">
        ヘッダー
    </header>
    <nav class="nav mdc-elevation--z2">
        <button class="nav__button">
            <svg xmlns="http://www.w3.org/2000/svg" height="32" viewBox="0 0 24 24" width="32"><path d="M0 0h24v24H0z" fill="none"/><path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"/></svg>
        </button>
        <button class="nav__button">
            <svg xmlns="http://www.w3.org/2000/svg" height="32" viewBox="0 0 24 24" width="32"><path d="M0 0h24v24H0z" fill="none"/><path d="M19.35 10.04C18.67 6.59 15.64 4 12 4 9.11 4 6.6 5.64 5.35 8.04 2.34 8.36 0 10.91 0 14c0 3.31 2.69 6 6 6h13c2.76 0 5-2.24 5-5 0-2.64-2.05-4.78-4.65-4.96zM14 13v4h-4v-4H7l5-5 5 5h-3z"/></svg>
        </button>
        <button class="nav__button">
            <svg xmlns="http://www.w3.org/2000/svg" height="32" viewBox="0 0 24 24" width="32"><path clip-rule="evenodd" d="M0 0h24v24H0z" fill="none"/><path d="M22.7 19l-9.1-9.1c.9-2.3.4-5-1.5-6.9-2-2-5-2.4-7.4-1.3L9 6 6 9 1.6 4.7C.4 7.1.9 10.1 2.9 12.1c1.9 1.9 4.6 2.4 6.9 1.5l9.1 9.1c.4.4 1 .4 1.4 0l2.3-2.3c.5-.4.5-1.1.1-1.4z"/></svg>
        </button>
        <button class="nav__button">
            <svg xmlns="http://www.w3.org/2000/svg" height="32" viewBox="0 0 24 24" width="32"><path d="M0 0h24v24H0z" fill="none"/><path d="M19 12v7H5v-7H3v7c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2v-7h-2zm-6 .67l2.59-2.58L17 11.5l-5 5-5-5 1.41-1.41L11 12.67V3h2z"/></svg>
        </button>
    </nav>
    <div class="container">

        <div class="left-column--show mdc-elevation--z4">
            <div class="left-column__search mdc-elevation--z2">
                <input class="left-column__search-form" type="text" placeholder="Search">
            </div>
            <div class="left-column__content">
                <div class="left-column__item">
                    <div class="left-column__item-thumbnail">
                        <img class="left-column__item-thumbnail-image" src="{{ asset('_static/image/森中完成_色調整_3_35.jpg') }}">
                    </div>
                    <div class="left-column__item-text">ファイル名</div>
                </div><!-- /.left-column__item -->
                <div class="left-column__item">
                    <div class="left-column__item-thumbnail">
                        <img class="left-column__item-thumbnail-image" src="{{ asset('_static/image/dummy.jpg') }}">
                    </div>
                    <div class="left-column__item-text">ファイル名</div>
                </div><!-- /.left-column__item -->
                <div class="left-column__item">
                    <div class="left-column__item-thumbnail">
                        <img class="left-column__item-thumbnail-image" src="{{ asset('_static/image/dummy.jpg') }}">
                    </div>
                    <div class="left-column__item-text">ファイル名</div>
                </div><!-- /.left-column__item -->
                <div class="left-column__item">
                    <div class="left-column__item-thumbnail">
                        <img class="left-column__item-thumbnail-image" src="{{ asset('_static/image/dummy.jpg') }}">
                    </div>
                    <div class="left-column__item-text">ファイル名</div>
                </div><!-- /.left-column__item -->
                <div class="left-column__item">
                    <div class="left-column__item-thumbnail">
                        <img class="left-column__item-thumbnail-image" src="{{ asset('_static/image/dummy.jpg') }}">
                    </div>
                    <div class="left-column__item-text">ファイル名</div>
                </div><!-- /.left-column__item -->
                <div class="left-column__item">
                    <div class="left-column__item-thumbnail">
                        <img class="left-column__item-thumbnail-image" src="{{ asset('_static/image/dummy.jpg') }}">
                    </div>
                    <div class="left-column__item-text">ファイル名</div>
                </div><!-- /.left-column__item -->
                <div class="left-column__item">
                    <div class="left-column__item-thumbnail">
                        <img class="left-column__item-thumbnail-image" src="{{ asset('_static/image/dummy.jpg') }}">
                    </div>
                    <div class="left-column__item-text">ファイル名</div>
                </div><!-- /.left-column__item -->
                <div class="left-column__item">
                    <div class="left-column__item-thumbnail">
                        <img class="left-column__item-thumbnail-image" src="{{ asset('_static/image/dummy.jpg') }}">
                    </div>
                    <div class="left-column__item-text">ファイル名</div>
                </div><!-- /.left-column__item -->
                <div class="left-column__item">
                    <div class="left-column__item-thumbnail">
                        <img class="left-column__item-thumbnail-image" src="{{ asset('_static/image/dummy.jpg') }}">
                    </div>
                    <div class="left-column__item-text">ファイル名</div>
                </div><!-- /.left-column__item -->
                <div class="left-column__item">
                    <div class="left-column__item-thumbnail">
                        <img class="left-column__item-thumbnail-image" src="{{ asset('_static/image/dummy.jpg') }}">
                    </div>
                    <div class="left-column__item-text">ファイル名</div>
                </div><!-- /.left-column__item -->
                <div class="left-column__item">
                    <div class="left-column__item-thumbnail">
                        <img class="left-column__item-thumbnail-image" src="{{ asset('_static/image/dummy.jpg') }}">
                    </div>
                    <div class="left-column__item-text">ファイル名</div>
                </div><!-- /.left-column__item -->
                <div class="left-column__item">
                    <div class="left-column__item-thumbnail">
                        <img class="left-column__item-thumbnail-image" src="{{ asset('_static/image/dummy.jpg') }}">
                    </div>
                    <div class="left-column__item-text">ファイル名</div>
                </div><!-- /.left-column__item -->
                <div class="left-column__item">
                    <div class="left-column__item-thumbnail">
                        <img class="left-column__item-thumbnail-image" src="{{ asset('_static/image/dummy.jpg') }}">
                    </div>
                    <div class="left-column__item-text">ファイル名</div>
                </div><!-- /.left-column__item -->
                <div class="left-column__item">
                    <div class="left-column__item-thumbnail">
                        <img class="left-column__item-thumbnail-image" src="{{ asset('_static/image/dummy.jpg') }}">
                    </div>
                    <div class="left-column__item-text">ファイル名</div>
                </div><!-- /.left-column__item -->
                <div class="left-column__item">
                    <div class="left-column__item-thumbnail">
                        <img class="left-column__item-thumbnail-image" src="{{ asset('_static/image/dummy.jpg') }}">
                    </div>
                    <div class="left-column__item-text">ファイル名</div>
                </div><!-- /.left-column__item -->
                <div class="left-column__item">
                    <div class="left-column__item-thumbnail">
                        <img class="left-column__item-thumbnail-image" src="{{ asset('_static/image/dummy.jpg') }}">
                    </div>
                    <div class="left-column__item-text">ファイル名</div>
                </div><!-- /.left-column__item -->
                <div class="left-column__item">
                    <div class="left-column__item-thumbnail">
                        <img class="left-column__item-thumbnail-image" src="{{ asset('_static/image/dummy.jpg') }}">
                    </div>
                    <div class="left-column__item-text">ファイル名</div>
                </div><!-- /.left-column__item -->
                <div class="left-column__item">
                    <div class="left-column__item-thumbnail">
                        <img class="left-column__item-thumbnail-image" src="{{ asset('_static/image/dummy.jpg') }}">
                    </div>
                    <div class="left-column__item-text">ファイル名</div>
                </div><!-- /.left-column__item -->
                <div class="left-column__item">
                    <div class="left-column__item-thumbnail">
                        <img class="left-column__item-thumbnail-image" src="{{ asset('_static/image/dummy.jpg') }}">
                    </div>
                    <div class="left-column__item-text">ファイル名</div>
                </div><!-- /.left-column__item -->
            </div><!-- left-column__content -->
        </div><!-- /.left-column--show -->

        <div class="image-container">
            <div class="image-container__thumbnail">
                <img class="image-container__thumbnail-image mdc-elevation--z2" src="{{ asset('_static/image/森中完成_色調整_3_35.jpg') }}">
            </div>
            <div class="image-container__thumbnail">
                <img class="image-container__thumbnail-image mdc-elevation--z2" src="{{ asset('_static/image/dummy.jpg') }}">
            </div>
            <div class="image-container__thumbnail">
                <img class="image-container__thumbnail-image mdc-elevation--z2" src="{{ asset('_static/image/dummy.jpg') }}">
            </div>
            <div class="image-container__thumbnail">
                <img class="image-container__thumbnail-image mdc-elevation--z2" src="{{ asset('_static/image/dummy.jpg') }}">
            </div>
            <div class="image-container__thumbnail">
                <img class="image-container__thumbnail-image mdc-elevation--z2" src="{{ asset('_static/image/dummy.jpg') }}">
            </div>
            <div class="image-container__thumbnail">
                <img class="image-container__thumbnail-image mdc-elevation--z2" src="{{ asset('_static/image/dummy.jpg') }}">
            </div>
            <div class="image-container__thumbnail">
                <img class="image-container__thumbnail-image mdc-elevation--z2" src="{{ asset('_static/image/dummy.jpg') }}">
            </div>
            <div class="image-container__thumbnail">
                <img class="image-container__thumbnail-image mdc-elevation--z2" src="{{ asset('_static/image/dummy.jpg') }}">
            </div>
            <div class="image-container__thumbnail">
                <img class="image-container__thumbnail-image mdc-elevation--z2" src="{{ asset('_static/image/dummy.jpg') }}">
            </div>
            <div class="image-container__thumbnail">
                <img class="image-container__thumbnail-image mdc-elevation--z2" src="{{ asset('_static/image/dummy.jpg') }}">
            </div>
            <div class="image-container__thumbnail">
                <img class="image-container__thumbnail-image mdc-elevation--z2" src="{{ asset('_static/image/dummy.jpg') }}">
            </div>
            <div class="image-container__thumbnail">
                <img class="image-container__thumbnail-image mdc-elevation--z2" src="{{ asset('_static/image/dummy.jpg') }}">
            </div>
            <div class="image-container__thumbnail">
                <img class="image-container__thumbnail-image mdc-elevation--z2" src="{{ asset('_static/image/dummy.jpg') }}">
            </div>
            <div class="image-container__thumbnail">
                <img class="image-container__thumbnail-image mdc-elevation--z2" src="{{ asset('_static/image/dummy.jpg') }}">
            </div>
            <div class="image-container__thumbnail">
                <img class="image-container__thumbnail-image mdc-elevation--z2" src="{{ asset('_static/image/dummy.jpg') }}">
            </div>
            <div class="image-container__thumbnail">
                <img class="image-container__thumbnail-image mdc-elevation--z2" src="{{ asset('_static/image/dummy.jpg') }}">
            </div>
            <div class="image-container__thumbnail">
                <img class="image-container__thumbnail-image mdc-elevation--z2" src="{{ asset('_static/image/dummy.jpg') }}">
            </div>
            <div class="image-container__thumbnail">
                <img class="image-container__thumbnail-image mdc-elevation--z2" src="{{ asset('_static/image/dummy.jpg') }}">
            </div>
            <div class="image-container__thumbnail">
                <img class="image-container__thumbnail-image mdc-elevation--z2" src="{{ asset('_static/image/dummy.jpg') }}">
            </div>
        </div><!-- /.image-container -->

        <div class="right-column">
            <div class="right-column__item mdc-elevation--z2">
                <p class="right-column__item-title">ラベル名</p>
                <p class="right-column__item-description">
                    ラベルの説明<br>
                    ラベルの説明<br>
                </p>
            </div>
            <div class="right-column__item mdc-elevation--z2">
                <p class="right-column__item-title">ラベル名</p>
                <p class="right-column__item-description">
                    ラベルの説明<br>
                    ラベルの説明<br>
                </p>
            </div>
            <div class="right-column__item mdc-elevation--z2">
                <p class="right-column__item-title">ラベル名</p>
                <p class="right-column__item-description">
                    ラベルの説明<br>
                    ラベルの説明<br>
                </p>
            </div>
            <div class="right-column__item mdc-elevation--z2">
                <p class="right-column__item-title">ラベル名</p>
                <p class="right-column__item-description">
                    ラベルの説明<br>
                    ラベルの説明<br>
                </p>
            </div>
        </div><!-- /.right-column -->
    </div><!-- /.container -->
</body>

<script
  src="https://code.jquery.com/jquery-3.5.1.min.js"
  integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0="
  crossorigin="anonymous"></script>
<script>
$(function() {
    
    $('.right-column__item').click(function(e) {
        $(this)
            .removeClass('right-column__item')
            .addClass('right-column__item--selected');
        
        $(this)
            .find('.right-column__item-description')
            .removeClass('right-column__item-description')
            .addClass('right-column__item-description--show');
    });
});

$('.right-column').click(() => {
  let json = null;
    let formData = new FormData();
    formData.append('url', 'https://scraping-for-beginner.herokuapp.com/image');
    //ormData.append('url', 'https://momicha.net/index.htm');

    $.ajax({
        type: 'POST',
        contentType: false,
        processData: false,
        url: "{{ route('api.document.html') }}",
        data: formData,
        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')},
        dataType: 'json',
    }).done( (data) => {
      console.log(data);
      for(let index in data) {
        const html = `<img src="${data[index]}" style="width:50px; height: 50px; object-fit:cover;">`;
        $('.right-column').append(html);
      }
      
    }).fail( (XMLHttpRequest, textStatus, errorThrown) => {
      // Ajaxリクエストが失敗した時発動
  　　console.log("XMLHttpRequest : " + XMLHttpRequest.status);
  　　console.log("textStatus     : " + textStatus);
  　　console.log("errorThrown    : " + errorThrown.message);
    });
});
    
</script>
</html>