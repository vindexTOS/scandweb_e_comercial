import React, { Component } from "react";
import withRouter from "../Routing/withRouter";
import { fetchSingleProduct } from "../Store/Products/Products.thunk";
import { connect } from "react-redux";
import { StatusType } from "../Types/StatusInterface";
import { Product } from "../Types/ProductsInterface";
import ImageGallery from "../Components/Product/ImageGallery";

import ProductInfo from "../Components/Product/ProductInfo";

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
    const productQuery = `{ singleProduct(id: "${id}")   { name id product_id gallery inStock category description attributes { id name type items { id displayValue value } }  prices { id amount currency { label symbol } }   } }`;
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
    if (status === "succeeded" && product && product.gallery) {
      return (
        <main className={this.style.main}>
          <ImageGallery gallery={product.gallery} />
           <ProductInfo
          inStock={product.inStock}
            id={product.id}
            name={product.name}
            attributes={product.attributes}
            description={product.description}
            prices={product.prices}
            gallery={product.gallery}
            product_id={product.product_id}
          />
        </main>
      );
    }
    return null;
  }

  private style = {
    main: "flex items-start  w-[100%] h-[100vh] justify-center gap-[10rem] pt-40  ",
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
