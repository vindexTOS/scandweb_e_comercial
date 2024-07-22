import React, { Component } from "react";
import withRouter from "../Routing/withRouter";
import { fetchSingleProduct } from "../Store/Products/Products.thunk";
import { connect } from "react-redux";
import { StatusType } from "../Types/StatusInterface";
import { Product } from "../Types/ProductsInterface";
import ImageGallery from "../Components/ImageGallery";
 

interface SingleCardProps {
  params: {
    id: string;
  };
  status: StatusType;
  error: string | null;
  fetchSingleProduct: (query: string) => void;
  product: Product | null;
}

class SingleCard extends Component<SingleCardProps> {
  componentDidMount() {
    const { id } = this.props.params;
    this.fetchProductForCategory(id);
  }

  fetchProductForCategory(id: string) {
    const productQuery = `{ singleProduct(id: "${id}") { name id gallery inStock category prices { id amount currency { label symbol } } } }`;
    this.props.fetchSingleProduct(productQuery);
  }

  render() {
    const { status, error, product } = this.props;
   
    if (status === "loading") {
      return <div className="text-[9rem]">Loading...</div>;
    }
    if (status === "failed") {
      return <div className="text-[9rem]">Error: {error}</div>;
    }
    if (status === "succeeded" && product) {
      return (
        <main  className={this.style.main}>
          <ImageGallery gallery={product.gallery} />
          
        </main>
      );
    }
    return null;  
  }

  private style = {
    main: "flex items-center w-[100%] justify-center",
  };
}

const mapStateToProps = (state: any) => ({
  product: state.products.singleProduct, 
  status: state.products.status,
  error: state.products.error,
});

const mapDispatchToProps = {
  fetchSingleProduct,
};

export default connect(
  mapStateToProps,
  mapDispatchToProps
)(withRouter(SingleCard));