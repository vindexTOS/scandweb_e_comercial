import React from "react";

interface ImageGalleryProps {
  gallery: string[];
}

interface ImageGalleryState {
  imgIndex: number;
}

class ImageGallery extends React.Component<ImageGalleryProps, ImageGalleryState> {
  constructor(props: ImageGalleryProps) {
    super(props);
    this.state = {
      imgIndex: 0,
    };
  }

  handleImgChange = (newIndex: number) => {
    const { gallery } = this.props;
    if (newIndex < 0) {
      newIndex = gallery.length - 1; // Wrap around to the last image
    } else if (newIndex >= gallery.length) {
      newIndex = 0; // Wrap around to the first image
    }
    this.setState({
      imgIndex: newIndex,
    });
  };

  render() {
    const { gallery } = this.props;
    const { imgIndex } = this.state;

    return (
      <section className={this.style.gallerySection}>
       
        <div className={this.style.choseGalleryWrapper}>
          {gallery.map((url, index) => (
            <img
              onClick={() => this.handleImgChange(index)}
              className={this.style.smallImg}
              src={url}
              key={index}
            />
          ))}
        </div>
        <button
          className={this.style.arrow}
          onClick={() => this.handleImgChange(imgIndex - 1)}
        >
          &lt;
        </button>
        <img className={this.style.mainImg} src={gallery[imgIndex]} />
        <button
          className={this.style.arrow}
          onClick={() => this.handleImgChange(imgIndex + 1)}
        >
          &gt;
        </button>
      </section>
    );
  }

  private style = {
    gallerySection: "flex items-center",
    choseGalleryWrapper: "flex flex-col gap-1",
    smallImg: "w-[100px] h-[100px] cursor-pointer",
    mainImg: "",
    arrow: "cursor-pointer px-4 py-2 bg-gray-200 rounded-full",
  };
}

export default ImageGallery;