import React from "react";

interface ImageGalleryProps {
  gallery: string[];
}

interface ImageGalleryState {
  imgIndex: number;
}

class ImageGallery extends React.Component<
  ImageGalleryProps,
  ImageGalleryState
> {
  constructor(props: ImageGalleryProps) {
    super(props);
    this.state = {
      imgIndex: 0,
    };
  }

  handleImgChange = (newIndex: number) => {
    const { gallery } = this.props;
    if (newIndex < 0) {
      newIndex = gallery.length - 1;
    } else if (newIndex >= gallery.length) {
      newIndex = 0;
    }
    this.setState({
      imgIndex: newIndex,
    });
  };

  render() {
    const { gallery } = this.props;
    const { imgIndex } = this.state;

    return (
      <section className={this.style.gallerySection} data-testid="product-gallery">
      <div className={this.style.choseGalleryWrapper}>
        {gallery.slice(0, 5).map((url, index) => (
          <img
            onClick={() => this.handleImgChange(index)}
            className={this.style.smallImg}
            src={url}
            key={index}
            data-testid={`product-gallery-thumbnail-${index}`}
          />
        ))}
      </div>
      <div className={this.style.imgSliderWrapper}>
        <button
          className={`${this.style.arrow} left-[20px]`}
          onClick={() => this.handleImgChange(imgIndex - 1)}
        >
          &lt;
        </button>
        <img className={this.style.mainImg} src={gallery[imgIndex]} />
        <button
          className={`${this.style.arrow} right-[20px]`}
          onClick={() => this.handleImgChange(imgIndex + 1)}
        >
          &gt;
        </button>
      </div>
    </section>
    );
  }

  private style = {
    gallerySection: "flex items-start gap-5  ",
    choseGalleryWrapper: "flex flex-col gap-3 ",
    smallImg: "w-[79px] h-[80px] cursor-pointer",
    imgSliderWrapper: "flex justify-center items-center relative",
    mainImg: "w-[575px] h-[478px]",
    arrow:
      "cursor-pointer px-4 py-2 bg-gray-900/70 h-[40px] text-white absolute ",
  };
}

export default ImageGallery;
