import React, { Component } from "react";
import { Attribute, CartProductType, Price } from "../../Types/ProductsInterface";
import Attributes from "./Attributes";
import { connect } from "react-redux";
import { addToCart } from "../../Store/Cart/Cart.slice";

  

interface ProductInfoProps {
  attributes: Attribute[];
  description: string;
  name: string;
  id: string;
  prices: Price[];
  addToCart: (state: any) => void;
  cartProducts: any[];
  gallery:string[]
  attrabuteSelector:any


}

interface ProductInfoState {
  isExpanded: boolean;
  numberOfItems: number;
 
}

class ProductInfo extends Component<ProductInfoProps, ProductInfoState> {
  constructor(props: ProductInfoProps) {
    super(props);
    this.state = {
      isExpanded: false,
      numberOfItems: 0,
      // attrabuteSelector:{}
    };
   }

  componentDidMount(): void {
    let cart:  CartProductType[] = [];

    const storedCart = localStorage.getItem("cart-product");
    if (storedCart) {
      cart = JSON.parse(storedCart);
      this.handleNumberCount(cart);
    }
  }
  handleNumberCount(cart:  CartProductType[]) {
    this.setState((prevState) => ({
      numberOfItems: cart.filter(
        (item:  CartProductType) => item.id === this.props.id
      ).length,
    }));
  }

  // handleAttrabutes(key: string, value: string) {
  //   console.log(key,value)

  //   this.setState((prevState) => ({
  //     attrabuteSelector: {
  //       ...prevState.attrabuteSelector,
  //       [key]: value
  //     }
  //   }));
  // }
  handleCart(product:  CartProductType) {
    let cart:   CartProductType[] = [];
    product["selectedAttrabutes"] =  this.props.attrabuteSelector
    const storedCart = localStorage.getItem("cart-product");

    if (storedCart) {
      cart = JSON.parse(storedCart);
    }

    cart.push(product);
    this.handleNumberCount(cart);
    localStorage.setItem("cart-product", JSON.stringify(cart));

    this.props.addToCart(product);
  }
  toggleDescription = () => {
    this.setState((prevState) => ({
      isExpanded: !prevState.isExpanded,
    }));
  };

  render() {
    const { name, attributes, prices, description, id , gallery  } = this.props;
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
        <Attributes  attributes={attributes} />
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
            this.handleCart({ name, attributes, prices, description, id ,photo:gallery[0] })
          }
          className={this.style.btn}
        >
          Add To Cart +
          {this.state.numberOfItems > 0 && this.state.numberOfItems}
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
  attrabuteSelector:state.cart.attrabuteSelector
});

const mapDispatchToProps = {
  addToCart,
};

export default connect(mapStateToProps, mapDispatchToProps)(ProductInfo);
