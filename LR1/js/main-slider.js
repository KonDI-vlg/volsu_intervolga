import Swiper from 'https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.mjs'
class MainSlider{
    constructor(item) {
        this.block = item
        this.swiperContainer = this.block.querySelector(".main-slider__swiper")
        this.swiperButtonNext = this.block.querySelector(".main-slider__button.swiper-button-next")
        this.swiperButtonPrev = this.block.querySelector(".main-slider__button.swiper-button-prev")

        this.paginationContainer = this.block.querySelector(".main-slider__pagination")
        this.init()
    }
    init = () => {

        this.pagination = new Swiper(this.paginationContainer, {
            direction: 'vertical',
            spaceBetween: 10,
            slidesPerView: 'auto',
            loop: false,

        });

        this.swiper = new Swiper(this.swiperContainer, {
            // Optional parameters
            loop: false,

            // Navigation arrows
            navigation: {
                nextEl: this.swiperButtonNext,
                prevEl: this.swiperButtonPrev,
            },
            thumbs: {
                swiper: this.pagination
            }
        });
        // this.pagination.controller.control = this.swiper;
        // this.swiper.controller.control = this.pagination;
    }
    static init(){
        document.querySelectorAll(".main-slider").forEach((item) => new MainSlider(item))
    }

}

document.addEventListener("DOMContentLoaded", MainSlider.init)
