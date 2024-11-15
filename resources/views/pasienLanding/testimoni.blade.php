@extends('layouts.lpBase')
@section('testimoniUser')
 <!-- blog area start -->
 <section class="blog section-space__bottom">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section__title-wrapper text-center mb-60 mb-xs-40">
                    <h2 class="section__title mb-0 title-animation">Testimoni</h2>
                </div>
            </div>
        </div>

        <div class="row mb-minus-30">
            <div class="col-xl-4 col-md-6">
                <div class="blog__item mb-30">
                    <a href="blog-details.html"
                        class="blog__item-media d-block position-relative overflow-hidden">
                        <div class="panel wow"></div>
                        <img class="img-fluid" src="{{ asset('lpUser/assets/imgs/blog/blog-item-1.jpg') }}"
                            alt="image not found">
                    </a>

                    <div class="blog__item-content">
                        <div class="blog__item-content-date mb-15 mb-xs-10"><i
                                class="fa-solid fa-calendar-days"></i> <span>October 19, 2022</span></div>
                        <h4 class="mb-15 mb-xs-10"><a href="blog-details.html">Optimal Oasis Nurturing Health
                                in Every Aspect</a></h4>
                        <p class="mb-40 mb-xs-30">Explore the dynamic commerce through our insightful blogs.
                            Learn Explore the dynamic</p>

                        <a class="rr-a-btn" href="blog-details.html">View More <i
                                class="fa-solid fa-circle-plus"></i></a>
                    </div>
                </div>
            </div>

            <div class="col-xl-4 col-md-6">
                <div class="blog__item mb-30">
                    <a href="blog-details.html"
                        class="blog__item-media d-block position-relative overflow-hidden">
                        <div class="panel wow"></div>
                        <img class="img-fluid" src="{{ asset('lpUser/assets/imgs/blog/blog-item-2.jpg') }}"
                            alt="image not found">
                    </a>

                    <div class="blog__item-content">
                        <div class="blog__item-content-date mb-15 mb-xs-10"><i
                                class="fa-solid fa-calendar-days"></i> <span>October 19, 2022</span></div>
                        <h4 class="mb-15 mb-xs-10"><a href="blog-details.html">Embark on Health Wellness
                                Begins</a></h4>
                        <p class="mb-40 mb-xs-30">Explore the dynamic commerce through our insightful blogs.
                            Learn Explore the dynamic</p>

                        <a class="rr-a-btn" href="blog-details.html">View More <i
                                class="fa-solid fa-circle-plus"></i></a>
                    </div>
                </div>
            </div>

            <div class="col-xl-4 col-md-6">
                <div class="blog__item mb-30">
                    <a href="blog-details.html"
                        class="blog__item-media d-block position-relative overflow-hidden">
                        <div class="panel wow"></div>
                        <img class="img-fluid" src="{{ asset('lpUser/assets/imgs/blog/blog-item-3.jpg') }}"
                            alt="image not found">
                    </a>

                    <div class="blog__item-content">
                        <div class="blog__item-content-date mb-15 mb-xs-10"><i
                                class="fa-solid fa-calendar-days"></i> <span>October 19, 2022</span></div>
                        <h4 class="mb-15 mb-xs-10"><a href="blog-details.html">Flourishing Healthier Revive
                                Radiance</a></h4>
                        <p class="mb-40 mb-xs-30">Explore the dynamic commerce through our insightful blogs.
                            Learn Explore the dynamic</p>

                        <a class="rr-a-btn" href="blog-details.html">View More <i
                                class="fa-solid fa-circle-plus"></i></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section> 
@endsection