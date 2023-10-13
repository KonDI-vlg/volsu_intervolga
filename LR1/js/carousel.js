import Swiper from 'https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.mjs'
class MainSlider{
    constructor(item) {
        this.block = item
        this.swiperContainer = this.block.querySelector(".carousel-swiper__list")

        this.swiperThumb = this.block.querySelector(".carousel-swiper__nav")

        this.init()
    }
    init = () => {

        this.thumb = new Swiper(this.swiperThumb, {
            spaceBetween: 10,
            slidesPerView: 'auto',
            loop: false,
        });

        this.swiper = new Swiper(this.swiperContainer, {
            // Optional parameters
            loop: false,

            // Navigation arrows

            thumbs: {
                swiper: this.thumb
            }
        });
        // this.pagination.controller.control = this.swiper;
        // this.swiper.controller.control = this.pagination;
    }
    static init(){
        document.querySelectorAll(".carousel-swiper").forEach((item) => new MainSlider(item))
    }

}

document.addEventListener("DOMContentLoaded", MainSlider.init)
