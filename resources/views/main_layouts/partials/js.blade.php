		<!-- jQuery -->
        <script src="{{ asset('blog_template/js/jquery.min.js') }}"></script>
        <!-- jQuery Easing -->
        <script src="{{ asset('blog_template/js/jquery.easing.1.3.js') }}"></script>
        <!-- Bootstrap -->
        <script src="{{ asset('blog_template/js/bootstrap.min.js') }}"></script>
        <!-- Waypoints -->
        <script src="{{ asset('blog_template/js/jquery.waypoints.min.js') }}"></script>
        <!-- Stellar Parallax -->
        <script src="{{ asset('blog_template/js/jquery.stellar.min.js') }}"></script>
        <!-- Flexslider -->
        <script src="{{ asset('blog_template/js/jquery.flexslider-min.js') }}"></script>
        <!-- Owl carousel -->
        <script src="{{ asset('blog_template/js/owl.carousel.min.js') }}"></script>
        <!-- Magnific Popup -->
        <script src="{{ asset('blog_template/js/jquery.magnific-popup.min.js') }}"></script>
        <script src="{{ asset('blog_template/js/magnific-popup-options.js') }}"></script>
        <!-- Counters -->
        <script src="{{ asset('blog_template/js/jquery.countTo.js') }}"></script>
        <!-- Main -->
        <script src="{{ asset('blog_template/js/main.js') }}"></script>
    
        <script src="{{ asset('js/function.js') }}"></script>
    
    
        <!-- ==== JS TEAMPLATED KCNEWS jQuery Library ==== -->
        <!-- <script src="{{ asset('kcnew/frontend/js/jquery-3.2.1.min.js') }}"></script> -->
    
        <!-- ==== Bootstrap Framework ==== -->
        <!-- <script src="{{ asset('kcnew/frontend/js/bootstrap.min.js') }}"></script> -->
    
        <!-- ==== StickyJS Plugin ==== -->
        <script src="{{ asset('kcnew/frontend/js/jquery.sticky.min.js') }}"></script>
    
        <!-- ==== HoverIntent Plugin ==== -->
        <script src="{{ asset('kcnew/frontend/js/jquery.hoverIntent.min.js') }}"></script>
    
        <!-- ==== Marquee Plugin ==== -->
        <script src="{{ asset('kcnew/frontend/js/jquery.marquee.min.js') }}"></script>
    
        <!-- ==== Validation Plugin ==== -->
        <script src="{{ asset('kcnew/frontend/js/jquery.validate.min.js') }}"></script>
    
        <!-- ==== Isotope Plugin ==== -->
        <script src="{{ asset('kcnew/frontend/js/isotope.min.js') }}"></script>
    
        <!-- ==== Resize Sensor Plugin ==== -->
        <script src="{{ asset('kcnew/frontend/js/resizesensor.min.js') }}"></script>
    
        <!-- ==== Sticky Sidebar Plugin ==== -->
        <script src="{{ asset('kcnew/frontend/js/theia-sticky-sidebar.min.js') }}"></script>
    
        <!-- ==== Zoom Plugin ==== -->
        <script src="{{ asset('kcnew/frontend/js/jquery.zoom.min.js') }}"></script>
    
        <!-- ==== Bar Rating Plugin ==== -->
        <script src="{{ asset('kcnew/frontend/js/jquery.barrating.min.js') }}"></script>
    
        <!-- ==== Countdown Plugin ==== -->
        <script src="{{ asset('kcnew/frontend/js/jquery.countdown.min.js') }}"></script>
    
        <!-- ==== RetinaJS Plugin ==== -->
        <script src="{{ asset('kcnew/frontend/js/retina.min.js') }}"></script>
    
        <!-- ==== Main JavaScript ==== -->
        <script src="{{ asset('kcnew/frontend/js/main.js') }}"></script>
        
        
        <script >
            $(function(){
    
                function isEmail(email) {
                    var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
                    return regex.test(email);
                }
                $(document).on("click", "#subscibe-btn", (e) => {
                    e.preventDefault();
                    let _this = $(e.target);
            
                    let email = _this.parents("form").find("input[name='subscribe-email']").val();
                    if( ! isEmail( email))
                    {
                        $("body").append("<div class='global-message alert alert-danger subscribe-error'>Không đúng định dạng email.</div>");
                    }
                    else
                    {
                        //send email
                        //1 using ajax
                        let formData = new FormData();
                        let _token = $("meta[name='_token']").attr("content");
                         
                        formData.append('_token', _token);
                        formData.append('email', email);
    
                        $.ajax({
                            url: "{{ route('newsletter_store') }}",
                            type: "POST",
                            dataType: "JSON",
                            processData: false,
                            contentType: false,
                            data: formData,
                            success: (respond) => {
                                let message = respond.message;
                                $("body").append("<div class='global-message alert alert-danger subscribe-success'>"+ message +"</div>");
                            
                                _this.parents("form").find("input[name='subscribe-email']").val('');
                            },
                            statusCode: {
                                500: () => {								 
                                    $("body").append("<div class='global-message alert alert-danger subscribe-error'>Email này đã subscribe website chúng tôi</div>");
    
                                }
                            } 
                        });
                         
                    }
                    setTimeout( () => {
         
                        $(".global-message.subscribe-error, .global-message.subscribe-success").remove();
    
                    }, 5000 );
                });
            });
        </script>