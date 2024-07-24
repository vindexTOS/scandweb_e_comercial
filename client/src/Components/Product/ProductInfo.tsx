import React, { Component } from "react";
import { Attribute, Price } from "../../Types/ProductsInterface";
import Attributes from "./Attributes";
import { connect } from "react-redux";
import { addToCart } from "../../Store/Cart/Cart.slice";

interface ProductInfoProps {
  attributes: Attribute[];
  description: string;
  name: string;
  prices: Price[];
  addToCart: (state: any) => void;
  cartProducts: any[];
}

interface ProductInfoState {
  isExpanded: boolean;
}

class ProductInfo extends Component<ProductInfoProps, ProductInfoState> {
  constructor(props: ProductInfoProps) {
    super(props);
    this.state = {
      isExpanded: false,
    };
  }
  handleCart = (product: any) => {
    this.props.addToCart(product);
  };
  toggleDescription = () => {
    this.setState((prevState) => ({
      isExpanded: !prevState.isExpanded,
    }));
  };

  render() {
    const { name, attributes, prices, description } = this.props;
    const { isExpanded } = this.state;
    const maxLength = 500;

    const renderDescription = () => {
      if (description.length <= maxLength || isExpanded) {
        return (
          <>
            <p
              className="w-[300px] cursor-pointer"
              dangerouslySetInnerHTML={{
                __html: description.replace(/\\n/g, "<br>"),
              }}
            />
            {description.length >= maxLength && (
              <button
                className="text-blue-500  "
                onClick={this.toggleDescription}
              >
                {isExpanded ? "Show less" : "Read more"}
              </button>
            )}
          </>
        );
      } else {
        const truncatedText = description.slice(0, maxLength) + " ...";
        return (
          <>
            <p
              className="w-[300px] cursor-pointer"
              dangerouslySetInnerHTML={{
                __html: truncatedText.replace(/\\n/g, "<br>"),
              }}
            />

            <button
              className="text-blue-500  "
              onClick={this.toggleDescription}
            >
              {isExpanded ? "Show less" : "Read more"}
            </button>
          </>
        );
      }
    };

    return (
      <div className={this.style.main}>
        <h1 className={this.style.header}>{name}</h1>
        <Attributes attributes={attributes} />
        <div className={this.style.price}>
          <h1
            className={this.style.priceHeader}
            onClick={() => console.log(prices)}
          >
            PRICE:
          </h1>
          <div className="font-bold">
            <span>{prices[0].currency.symbol}</span>
            <span>{prices[0].amount}</span>
          </div>
        </div>
        <button
          onClick={() =>
            this.props.addToCart({ name, attributes, prices, description })
          }
          className={this.style.btn}
        >
          Add To Cart +
          {this.props.cartProducts.length > 0 && this.props.cartProducts.length}
        </button>

        {renderDescription()}
      </div>
    );
  }

  private style = {
    main: "flex flex-col gap-5 p",
    header: "text-[40px]",
    priceHeader: "text-[20px] font-bold ",
    price: "",
    btn: "bg-green-400 text-white   w-[292px] h-[52px]",
  };
}

const mapStateToProps = (state: any) => ({
  cartProducts: state.cart.cartProducts,
});

const mapDispatchToProps = {
  addToCart,
};

export default connect(mapStateToProps, mapDispatchToProps)(ProductInfo);
