import React, { Component } from "react";
import withRouter from "../Routing/withRouter";
import { fetchSingleProduct } from "../Store/Products/Products.thunk";
import { connect } from "react-redux";
import { StatusType } from "../Types/StatusInterface";
import { Product } from "../Types/ProductsInterface";

interface SingleCardProps {
  params: {
    id: string;
  };
  status: StatusType;
  error: string | null;
  fetchSingleProduct: (query: string) => void;
  product: Product;
}
interface SingleCardState {
  imgIndex: number;
}
class SingleCard extends Component<SingleCardProps, SingleCardState> {
  constructor(props: SingleCardProps) {
    super(props);
    this.state = {
      imgIndex: 0,
    };
  }

  handleImgChange = (newIndex: number) => {
    this.setState({
      imgIndex: newIndex,
    });
  };

  componentDidMount() {
    const { id } = this.props.params;
    this.fetchProductForCategory(id);
  }

  fetchProductForCategory(id: string) {
    const productQuery = `{  singleProduct(id: "${id}") { name id gallery inStock category prices { id amount currency { label symbol } }} }`;
    this.props.fetchSingleProduct(productQuery);
  }

  render() {
    const { status, error, product } = this.props;
    if (status == "loading") {
      return <div className="text-[9rem]">Loading... </div>;
    }
    if (status == "failed") {
      return <div className="text-[9rem]">LError </div>;
    }
    if (status === "succeeded")
      return (
        <main onClick={() => console.log(product)} className={this.style.main}>
          <section className={this.style.gallerySection}>
            <div className={this.style.choseGalleryWrapper}>
              {product?.gallery?.map((url: string, index: number) => (
                <img
                  onClick={() => this.handleImgChange(index)}
                  className={this.style.smallImg}
                  src={url}
                  key={index}
                />
              ))}
            </div>
            <img
              className={this.style.mainImg}
              src={product.gallery[this.state.imgIndex]}
            />
          </section>
        </main>
      );
  }

  private style = {
    main: "flex items-center w-[100%]   justify-center",
    gallerySection: "flex  items-center ",
    choseGalleryWrapper: "",
    smallImg: "w-[100px] h-[80px]  ",
    mainImg: "",
  };
}
const mapStateToProps = (state: any) => ({
  product: state.products.singleProdsuct,
});

const mapDispatchToProps = {
  fetchSingleProduct,
};

export default connect(
  mapStateToProps,
  mapDispatchToProps
)(withRouter(SingleCard));
