<head>
    <!-- meta tags -->
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="keywords" content="">

    <!-- title -->
    <title>{{setting("site_name")}}</title>

    <!-- favicon -->
    <link rel="icon" type="image/x-icon" href="assets/img/logo/favicon.png">

    <!-- css -->
    <link rel="stylesheet" href="{{asset('assets/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/all-fontawesome.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/animate.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/magnific-popup.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/owl.carousel.min.css')}}">
    <link rel="stylesheet" href="{{asset('assets/css/style.css')}}">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <style>
.searh-wrapper {
    padding: 10px 41px 29px;
    background-color: #1a1e37;
    /* margin: 20px; */
    background-size: contain;
    background-image: url(http://filament.test/filament-cms/public/assets/img/slider/map-bg.png);
}
        .feature-item{
            display: flex;
            flex-direction: column;
            text-align: center;
            align-items: center;
            border-radius: 20px;
            padding: 20px 19px;
        }
        .counter-box .icon {
            position: relative;
            text-align: center;
            font-size: 60px;
            width: 100%;
            height: 149px;
            line-height: 88px;
            color: var(--color-white);
            background: var(--theme-color2);
            border-radius: 30% 70% 70% 30% / 30% 30% 70% 70%;
        }
        .counter-box .title {
            color: var(--color-white);
            margin-top: 20px;
            font-size: 32px;
            font-weight: 600;
            text-transform: capitalize;
        }
        .about-img .img-1 {
            border-radius: 41px;
        }
        .event-item {
    position: relative;
    background: var(--color-white);
    border-radius: 20px;
    padding: 20px 20px 20px 20px;
    margin-bottom: 25px;
    box-shadow: var(--box-shadow);
}
.event-item .event-location .course-level {
    font-size: 13px;
    font-weight: 500;
    color: var(--color-white);
    font-family: var(--font-secondary);
    background-color: #cd201f;
    border-radius: 3px;
    padding: 1px 10px;
    margin-bottom: 15px;
    display: inline-block;
}

.event-item .event-location .course-level2 {
    font-size: 13px;
    font-weight: 500;
    color: var(--color-white);
    font-family: var(--font-secondary);
    background-color: var(--theme-color);
    border-radius: 3px;
    padding: 1px 10px;
    margin-bottom: 15px;
    display: inline-block;
}

.theme-btn-read-download {
    font-size: 14px;
    color: var(--color-white);
    padding: 14px 20px;
    transition: var(--transition);
    text-transform: uppercase;
    position: relative;
    border-radius: 5px;
    font-weight: 600;
    letter-spacing: 1px;
    cursor: pointer;
    text-align: center;
    overflow: hidden;
    border: none;
    background: #c0c0c0;
    box-shadow: var(--box-shadow);
    z-index: 1;
}

.team-item {
    position: relative;
    background: var(--color-white);
    padding: 15px;
    margin-bottom: 25px;
    border-radius: 20px;
    overflow: hidden;
    box-shadow: var(--box-shadow);
    transition: var(--transition);
}

.team-img img {
    height: 300px;
    width: 100%;
    object-fit: cover;

    border-radius: 10px;
}

.video-content::before {
    content: "";
    position: absolute;
    background: rgba(3, 2, 7, .2);
    border-radius: 10px;
    width: 100%;
    height: 100%;
    left: 0;
    top: 0;
}

.video-content {
    position: relative;
    background-repeat: no-repeat;
    background-position: center;
    background-size: cover;
    border-radius: 10px;
}

   .banner-text {
    position: absolute;
    top: 27%;
    z-index: 1;
    width: 100%;
    text-align: center;
}
.banner-form-box {
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    width: 80%;
    background-color: #fff;
    border-radius: 4px;
    box-shadow: 0 2px 12px rgba(0, 0, 0, .09);
    margin: 20px auto 0;
}
.banner-form-input {
    padding: 10px 12px;
    border-right: 1px solid #e4e4e4;
    -webkit-box-flex: 1;
    -ms-flex: 1;
    flex: 1;
    -webkit-box-align: center;
    -ms-flex-align: center;
    align-items: center;
    display: -webkit-box;
    display: -ms-flexbox;
    display: flex;
    position: relative;
}

.banner-form-input input {
    padding: 5px 10px;
    width: 100%;
    border: medium none;
}

.banner-form-input button {
    position: absolute;
    left: 0;
    top: 0;
    height: 100%;
    margin: 0;
    width: 100%;
    border: medium none;
    cursor: pointer;
    background: var(--theme-color2);
    color: #fff;
    border-radius: 0px 4px 4px 0px;
    -webkit-transition: all 0.4s ease 0s;
    transition: all 0.4s ease 0s;
}



    </style>

</head>
