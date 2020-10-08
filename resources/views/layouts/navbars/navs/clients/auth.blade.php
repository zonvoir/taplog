<style>
  .start-header {
    opacity: 1;
    transform: translateY(0);
    padding: 20px 0;
    box-shadow: 0 10px 30px 0 rgba(138, 155, 165, 0.15);
    -webkit-transition: all 0.3s ease-out;
    transition: all 0.3s ease-out;
  }
  .start-header.scroll-on {
    box-shadow: 0 5px 10px 0 rgba(138, 155, 165, 0.15);
    padding: 10px 0;
    -webkit-transition: all 0.3s ease-out;
    transition: all 0.3s ease-out;
  }
  .start-header.scroll-on .navbar-brand img {
    height: 24px;
    -webkit-transition: all 0.3s ease-out;
    transition: all 0.3s ease-out;
  }
  .navigation-wrap {
    position: absolute;
    width: 100%;
    top: 0;
    left: 0;
    z-index: 1000;
    -webkit-transition: all 0.3s ease-out;
    transition: all 0.3s ease-out;
    background-color: #1f7cca;
  }
  .navbar {
    padding: 0;
  }
  .navbar-brand img {
    height: 35px;
    width: auto;
    display: block;

  }
  .navbar-toggler {
    float: right;
    border: none;
    padding-right: 0;
  }
  .navbar-toggler:active,
  .navbar-toggler:focus {
    outline: none;
  }
  .navbar-light .navbar-toggler-icon {
    width: 24px;
    height: 17px;
    background-image: none;
    position: relative;
    border-bottom: 1px solid #000;
    transition: all 300ms linear;
  }
  .navbar-light .navbar-toggler-icon:after,
  .navbar-light .navbar-toggler-icon:before {
    width: 24px;
    position: absolute;
    height: 1px;
    background-color: #000;
    top: 0;
    left: 0;
    content: "";
    z-index: 2;
    transition: all 300ms linear;
  }
  .navbar-light .navbar-toggler-icon:after {
    top: 8px;
  }
  .navbar-toggler[aria-expanded="true"] .navbar-toggler-icon:after {
    transform: rotate(45deg);
  }
  .navbar-toggler[aria-expanded="true"] .navbar-toggler-icon:before {
    transform: translateY(8px) rotate(-45deg);
  }
  .navbar-toggler[aria-expanded="true"] .navbar-toggler-icon {
    border-color: transparent;
  }
  .nav-link {
    color: #212121 !important;
    font-weight: 500;
    transition: all 200ms linear;
  }
  .nav-item:hover .nav-link {
    color: black !important;
  }
  .nav-item.active .nav-link {
    color: #777 !important;
  }
  .nav-link {
    position: relative;
    padding: 5px 0 !important;
    display: inline-block;
  }
/*
.nav-item:after {
  position: absolute;
  bottom: -5px;
  left: 0;
  width: 100%;
  height: 2px;
  content: "";
  background-color: black;
  opacity: 0;
  transition: all 200ms linear;
}
.nav-item:hover:after {
  bottom: -20px;
  opacity: 1;
}
*/
.nav-item.active:hover:after {
  opacity: 0;
}
.nav-item {
  position: relative;
  transition: all 200ms linear;
}

.navigation-wrap li a i {
  font-size: 15px;
  color: #fff;
}

.navigation-wrap li a {
  font-size: 15px;
  color: #fff;
}

.dropdown-menu-right {
  right: 0;
  left: auto;
}

.navigation-wrap .dropdown-menu {
  margin-top: 19px;
}

.navigation-wrap .dropdown-menu a{color: black}






 /**********************************************

          MOBILE RESPONSIVE

          **********************************************/



          @media(max-width:767px) {


           .navigation-wrap .bg-white {
            background-color: #1f7cca !important;
          } 
          
          
          
          .navigation-wrap .dropdown-toggle:after{display: none}
          .navigation-wrap .dropdown-menu:before{display: none}
          
          
          .navbar-nav li {
            padding: 0 10px;
            margin-bottom: 15px;
          }
          
          .dropdown-menu {
            position: absolute;
            top: 100%;
            left: 0;
            z-index: 1000;
            display: none;
            float: left;
            min-width: 10rem;
            padding: 0.5rem 0;
            margin: 0.125rem 0 0;
            font-size: 0.875rem;
            color: #525f7f;
            text-align: left;
            list-style: none;
            background-color: transparent;
            background-clip: padding-box;
            border: 0 solid rgba(34, 42, 66, 0.15);
            border-radius: 0.1428rem;
            box-shadow: inherit !important;
          }
          
          .dropdown-item {
            display: block;
            width: 100%;
            padding: 0;}
            
            .navigation-wrap .dropdown-menu a {
              color: white;
              padding: 4px 0 !important;
              padding-left: 13px !important;
            }
            
            .navigation-wrap .dropdown-menu {
              margin-top: 0px;
            }
            
            .start-header {

              padding-bottom: 0;
            }
            
            
            
          }


          /*For small mobile devices*/
          @media (min-width:320px) and (max-width:479px) {
          }

          /*For landscape mobiles devices*/
          @media (max-width:736px) and (orientation:landscape) {

          }

          /*For small screens and laptops devices*/
          @media (min-width:980px) and (max-width:1199px) {
          }

          @media (min-width:1200px) and (max-width:1399px) {
          }

        </style>
        <div class="hero-anime">
          <div class="navigation-wrap start-header start-style">
            <div class="container-fluid">
              <div class="row">
                <div class="col-12">
                  <nav class="navbar navbar-expand-md navbar-light">

                    <a class="navbar-brand" href="" target="_blank"><img src="{{ asset('public/black') }}/img/fcy.png" alt=""></a>

                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                      <span class="navbar-toggler-icon"></span>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                      <ul class="navbar-nav ml-auto py-4 py-md-0">
                        @if(Auth::user())
                        <li class="nav-item pl-4 pl-md-0 ml-0 ml-md-4">
                        <a href="{{ route('index') }}">{{ __('Home') }}</a>
                      </li>
                        <li class="nav-item pl-4 pl-md-0 ml-0 ml-md-4">
                          <a class="nav-link- dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">Profile <i class="fas fa-angle-down"></i></a>
                          <div class="dropdown-menu dropdown-menu-right">
                            <span class="dropdown-item">{{__('Hi ')}}{{ Auth::user()->name }}</span>
                            <a href="{{ route('logout') }}" class="dropdown-item" onclick="event.preventDefault();  document.getElementById('logout-form').submit();">{{ __('Log out') }}</a>
                          </div>
                        </li>
                        @endif
                      </ul>
                    </div>
                  </nav>
                </div>
              </div>
            </div>
          </div>
        </div>
        <script>
         (function ($) {
          "use strict";

          $(function () {
            var header = $(".start-style");
            $(window).scroll(function () {
              var scroll = $(window).scrollTop();

              if (scroll >= 10) {
                header.removeClass("start-style").addClass("scroll-on");
              } else {
                header.removeClass("scroll-on").addClass("start-style");
              }
            });
          });

  //Animation

  $(document).ready(function () {
    $("body.hero-anime").removeClass("hero-anime");
  });

  //Menu On Hover

  $("body").on("mouseenter mouseleave", ".nav-item", function (e) {
    if ($(window).width() > 750) {
      var _d = $(e.target).closest(".nav-item");
      _d.addClass("show");
      setTimeout(function () {
        _d[_d.is(":hover") ? "addClass" : "removeClass"]("show");
      }, 1);
    }
  });

  //Switch light/dark

})(jQuery); 
</script>
