<!DOCTYPE html>
<html lang="en">
<head>
    <?php
        include("head.php");
    ?>
    <title>.:: D O L A N C Y ::.</title>
</head><!--/head-->
<body>
    <?php
        include("menu.php");
    ?>
    
<!--  	<section id="testimonial" class="alizarin" style="padding: 10px 0 50px 0;"> -->
<!--         <div class="container"> -->
<!--             <div class="row"> -->
<!--                 <div class="col-lg-12"> -->
<!--                     <div class="center"> -->
<!--                         <h1>¡Falta poco para <a href="ercaj-mexico.php">Dolan</a>!</h1> -->
<!--                         <p>Ya queda poco tiempo para dar inicio al próximo ERCaJ México 2014</p><br/> -->
<!--                     </div> -->
<!--                 </div> -->
<!--             </div> -->
<!--         </div> -->
<!--     </section> -->
    
    <section id="main-slider" class="no-margin">
        <div class="carousel slide wet-asphalt">
            <ol class="carousel-indicators">
                <li data-target="#main-slider" data-slide-to="0" class="active"></li>
                <li data-target="#main-slider" data-slide-to="1"></li>
                <li data-target="#main-slider" data-slide-to="2"></li>
            </ol>
            <div class="carousel-inner">
                <div class="item active" style="background-image: url(images/slider/dolancy.png)">
                    <div class="container">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="carousel-content centered">
                                    <h2 class="animation animated-item-1" style="font-size: 12.0em; font-family: 'Open Sans', sans-serif;">ERCaJ</h2>
                                    <p class="animation animated-item-2" style="font-size: 1.5em; letter-spacing: 2px;"><code>E</code>ncuentro &nbsp;&nbsp;<code>R</code>enovado &nbsp;&nbsp;<code>Ca</code>tólico &nbsp;&nbsp;<code>J</code>uvenil</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!--/.item-->
                <div class="item" style="background-image: url(images/slider/bg2.jpg)">
                    <div class="container">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="carousel-content center centered">
                                    <h2 class="boxed animation animated-item-1">Clean, Crisp, Powerful and Responsive Web Design</h2>
                                    <p class="boxed animation animated-item-2">Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas.</p>
                                    <br>
                                    <a class="btn btn-md animation animated-item-3" href="#">Learn More</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!--/.item-->
                <div class="item" style="background-image: url(images/slider/bg3.jpg)">
                    <div class="container">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="carousel-content centered">
                                    <h2 class="animation animated-item-1">Powerful and Responsive Web Design Theme</h2>
                                    <p class="animation animated-item-2">Pellentesque habitant morbi tristique senectus et netus et malesuada fames</p>
                                    <a class="btn btn-md animation animated-item-3" href="#">Learn More</a>
                                </div>
                            </div>
                            <div class="col-sm-6 hidden-xs animation animated-item-4">
                                <div class="centered">
                                    <div class="embed-container">
                                        <iframe src="//player.vimeo.com/video/97952119?title=0&amp;byline=0&amp;portrait=0&amp;color=a22c2f" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen></iframe>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!--/.item-->
            </div><!--/.carousel-inner-->
        </div><!--/.carousel-->
        <a class="prev hidden-xs" href="#main-slider" data-slide="prev">
            <i class="icon-angle-left"></i>
        </a>
        <a class="next hidden-xs" href="#main-slider" data-slide="next">
            <i class="icon-angle-right"></i>
        </a>
    </section><!--/#main-slider-->

    <section id="testimonial">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="center">
                        <iframe src="//player.vimeo.com/video/97952119?title=0&amp;byline=0&amp;portrait=0&amp;color=a22c2f" frameborder="0" webkitallowfullscreen mozallowfullscreen allowfullscreen width="100%" height="580"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section id="services" class="emerald">
        <div class="container">
            <div class="row">
                <div class="col-md-4 col-sm-6">
                    <div class="media">
                        <div class="pull-left">
                            <i class="icon-instagram icon-md"></i>
                        </div>
                        <div class="media-body">
                            <a href="https://instagram.com/dolancy" target="_blank">
                                <h3 class="media-heading">Dolancy</h3>
                            </a>
                            <p>Síguenos en <a href="https://instagram.com/dolancy" target="_blank">@dolancy</a></p>
                            <p>#DolancyShoes</p>
                        </div>
                    </div>
                </div><!--/.col-md-4-->
                <div class="col-md-4 col-sm-6">
                    <div class="media">
                        <div class="pull-left">
                            <i class="icon-facebook icon-md"></i>
                        </div>
                        <div class="media-body">
                            <a href="https://www.facebook.com/dolancy" target="_blank">
                                <h3 class="media-heading">Facebook Dolancy</h3>
                            </a>
                            
                        </div>
                    </div>
                </div><!--/.col-md-4-->
                <div class="col-md-4 col-sm-6">
                    <div class="media">
                        <div class="pull-left">
                            <i class="icon-youtube icon-md"></i>
                        </div>
                        <div class="media-body">
                            <a href="https://www.youtube.com/channel/UCdZqzwJD3o8QMdUs8HdgUEA" target="_blank">
                                <h3 class="media-heading">YouTube Dolancy</h3>
                            </a>
                            <p>Nuestros videos.</p>
                        </div>
                    </div>
                </div><!--/.col-md-4-->
            </div>
        </div>
    </section><!--/#services-->

    <?php
        include("footer.php");
    ?>

    <script src="js/jquery.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.prettyPhoto.js"></script>
    <script src="js/main.js"></script>
    <script src="js/jquery.countdown.js"></script>

    <div id="fb-root"></div>
</body>
</html>