import React, { Component } from "react";
import { CartProductType, Product } from "../../Types/ProductsInterface";
import { Link } from "react-router-dom";
import Cart from "../../Assets/Empty Cart.png";
import { connect } from "react-redux";
 import { addArrayToCart, addToCart, handleShowCart, handleStatus } from "../../Store/Cart/Cart.slice";
 

interface ProductCardProps {
  product: Product;
   cartItems: CartProductType[];
  addToCart: (product: CartProductType) => void;
 
}

interface ProductCardState {
  isHovered: boolean;
  cartItems: CartProductType[];

}

class ProductCard extends Component<ProductCardProps, ProductCardState> {
  constructor(props: ProductCardProps) {
    super(props);
   
    this.state = {
      isHovered: false,
      cartItems: [],
    };
  }

  handleMouseEnter = () => {
    this.setState({ isHovered: true });
  };

  handleMouseLeave = () => {
    this.setState({ isHovered: false });
  };

 
  handleCart(product: any) {
    console.log(product);
  
    let cart: CartProductType[] = [];
  
    // Create an object with attribute names as keys and their first item's value as the value
    const selectedAttrabutes = product.attributes.reduce((acc: any, attribute: any) => {
      acc[attribute.name] = attribute.items[0].value;
      return acc;
    }, {});
  
    // Create the result product with the selected attributes and photo
    let resultProduct = {
      ...product,
      selectedAttrabutes,
      photo: product.gallery[0]
    };
  
    const storedCart = localStorage.getItem("cart-product");
    if (storedCart) {
      cart = JSON.parse(storedCart);
    }
  
    cart.push(resultProduct);
  
    localStorage.setItem("cart-product", JSON.stringify(cart));
  
    this.props.addToCart(resultProduct);
  }
  render() {
    const { product } = this.props;
    const { isHovered } = this.state;

    return (
      <div 
        onMouseEnter={this.handleMouseEnter}
        onMouseLeave={this.handleMouseLeave}
        className={this.style.mainDiv}
      >
        <Link to={product.id} className={this.style.link}>
          <div className={this.style.photoWrapper}>
            <img className={this.style.img} src={product.gallery[0]} />
            {!product.inStock && (
              <div className={this.style.outofstock}>OUT OF STOCK</div>
            )}
          </div>
          <div className={this.style.nameAndPriceWrapper}>
            <h3 className={this.style.name}>{product.name} </h3>
            <p>
              {product.prices[0].currency.symbol}
              {product.prices[0].amount}
            </p>
          </div>
        </Link>
        {isHovered && product.inStock && (
          <button 
          onClick={() =>
            this.handleCart(product)
          }
            className={this.style.quickShopButton}
          >
            <img src={Cart } />
            
          </button>
        )}
      </div>
    );
  }

  private style = {
    mainDiv:
      "relative w-[368px] h-[400px] hover:shadow-xl flex flex-col items-center",
    link: "w-full h-full flex flex-col items-center",
    img: "w-[354px] h-[330px] p-2",
    nameAndPriceWrapper: "flex flex-col justify-start items-start w-[100%] px-5",
    name: "text-gray-400",
    photoWrapper: "relative",
    outofstock: "absolute top-40 left-[4rem] text-[2rem] text-gray-200",
    quickShopButton: "absolute bottom-5 right-5 bg-green-500 text-white p-2 rounded-[50%]",
  };
}
const mapStateToProps = (state: any) => ({
  cartItems: state.cart.cartProducts,
  showCart: state.cart.showCart,
  status:state.cart.status
});

const mapDispatchToProps = {
  addToCart,
};

export default connect(mapStateToProps, mapDispatchToProps)( ProductCard)