import React, { Component } from "react";
import { connect } from "react-redux";
import {
  addArrayToCart,
  addToCart,
  handleShowCart,
  handleStatus,
} from "../../Store/Cart/Cart.slice";
import CartItemCard from "./CartItemCard";
import { CartProductType } from "../../Types/ProductsInterface";
import { postOrder } from "../../Store/Cart/Cart.thunk";
import { StatsFs } from "fs";
import Status from "../Status/Status";
import { StatusType } from "../../Types/StatusInterface";

interface CartOverLayProps {
  handleShowCart: (bool: boolean) => void;
  cartItems: CartProductType[];
  addToCart: (product: CartProductType) => void;
  addArrayToCart: (product: any) => void;
  showCart: boolean;
  postOrder: ( {product_id  , attributes  }:{product_id:string , attributes :any} ) => void;
  status:StatusType
  handleStatus:()=>void;
}

interface CartOverlayState {
  cartItems: CartProductType[];
}

class CartOverlay extends Component<CartOverLayProps, CartOverlayState> {
  overlayRef: React.RefObject<HTMLDivElement>;

  constructor(props: CartOverLayProps) {
    super(props);
    this.overlayRef = React.createRef();
    this.handleClickOutside = this.handleClickOutside.bind(this);
    this.handleCart = this.handleCart.bind(this);
    this.handleRemove = this.handleRemove.bind(this);
    this.state = {
      cartItems: [],
    };
  }

  componentDidMount() {
    document.addEventListener("mousedown", this.handleClickOutside);

    let cartItemsLocal = localStorage.getItem("cart-product");
    if (cartItemsLocal) {
      this.setState({
        cartItems: JSON.parse(cartItemsLocal) as CartProductType[],
      });
    }
  }

  componentWillUnmount() {
    document.removeEventListener("mousedown", this.handleClickOutside);
  }

  handleClickOutside(event: MouseEvent) {
    if (
      this.overlayRef.current &&
      !this.overlayRef.current.contains(event.target as Node)
    ) {
      this.props.handleShowCart(!this.props.showCart);
    }
  }

  handleCart(product: CartProductType) {
    let cart: CartProductType[] = [];

    const storedCart = localStorage.getItem("cart-product");
    if (storedCart) {
      cart = JSON.parse(storedCart);
    }

    cart.push(product);

    localStorage.setItem("cart-product", JSON.stringify(cart));

    this.props.addToCart(product);

    this.setState({ cartItems: cart });
  }

  handleRemove(product: CartProductType) {
    let cart: CartProductType[] = [];

    const storedCart = localStorage.getItem("cart-product");
    if (storedCart) {
      cart = JSON.parse(storedCart);
    }

    const index = cart.findIndex(
      (item) =>
        item.id === product.id &&
        JSON.stringify(item.selectedAttrabutes) ===
          JSON.stringify(product.selectedAttrabutes)
    );

    if (index !== -1) {
      cart.splice(index, 1);
    }

    localStorage.setItem("cart-product", JSON.stringify(cart));
    this.props.addArrayToCart(cart);
    this.setState({ cartItems: cart });
  }

  groupCartItems(cartItems: CartProductType[]) {
    const groupedItems: {
      [key: string]: { item: CartProductType; count: number };
    } = {};

    cartItems.forEach((item) => {
      const uniqueKey = `${item.id}-${JSON.stringify(item.selectedAttrabutes)}`;
      if (groupedItems[uniqueKey]) {
        groupedItems[uniqueKey].count += 1;
      } else {
        groupedItems[uniqueKey] = { item, count: 1 };
      }
    });

    return Object.values(groupedItems);
  }

  handleMakeOrder() {
    const groupedCartItems: any = this.groupCartItems(this.state.cartItems);
 
    for (let i = 0; i < groupedCartItems.length; i++) {
      const { item } = groupedCartItems[i];
      const { product_id, selectedAttrabutes } = item;
 
    console.log(product_id);
      const resultArray = Object.entries(selectedAttrabutes).map(([key, value]) => ({
        key,
        value
      }));
      
       this.props.postOrder({product_id,attributes : resultArray});
       setTimeout(()=>{
        this.props.handleStatus() 
        this.props. handleShowCart(false)},2000)
     
    }
  }

  render() {
    const { cartItems } = this.state;
    const groupedCartItems = this.groupCartItems(cartItems);

    return (
      <div className="fixed inset-0 top-20 z-50 flex items-start justify-end bg-black bg-opacity-50">
        <div
          ref={this.overlayRef}
          className="bg-white w-[425px] h-[628px] overflow-y-auto mr-20 shadow-lg flex flex-col gap-10"
        >
          <div className="px-10 py-4">
            <span className="text-xl font-bold mb-5 pb-10">My Bag,</span>{" "}
            <span data-testid='cart-total'>{cartItems.length} items</span>
          </div>
          <div className="w-[100%] py-10 flex flex-col gap-10">
            {groupedCartItems.length > 0 ? (
              groupedCartItems.map(({ item, count }, i) => (
                <CartItemCard
                  key={item.id + i}
                  {...item}
                  count={count}
                  handleCart={this.handleCart}
                  handleRemove={this.handleRemove}
                />
              ))
            ) : (
              <div className="flex items-center justify-center  ">No items in cart</div>
            )}
          </div>
          <div className="flex w-[100%] items-center justify-center pb-7">
            {/* realy */}
     <button   disabled={groupedCartItems.length  < 0 }
              onClick={() => this.handleMakeOrder()}
              className={`${groupedCartItems.length > 0 ? 'bg-green-400' : "  bg-gray-400"} text-white   w-[90%] text-center h-[52px]`} 
            >
              PLACE ORDER
            </button> 
          </div>
        </div>
        
    {this.props.status !== "idle"  ?  < Status message= {this.props.status === "failed" ? "Something went wrong" : "Order has been submited!"} type={this.props.status == "failed" ? "error" : ""} /> : "Loading..."}
      </div>
    );
  }
}

const mapStateToProps = (state: any) => ({
  cartItems: state.cart.cartProducts,
  showCart: state.cart.showCart,
  status:state.cart.status
});

const mapDispatchToProps = {
  handleShowCart,
  addToCart,
  addArrayToCart,
  postOrder,handleStatus,
};

export default connect(mapStateToProps, mapDispatchToProps)(CartOverlay);
