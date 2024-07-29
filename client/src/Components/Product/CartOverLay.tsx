import React, { Component } from "react";
import { connect } from "react-redux";
import withRouter from "../../Routing/withRouter";
import { handleShowCart } from "../../Store/Cart/Cart.slice";
 
import CartItemCard from "./CartItemCard";
import { CartProductType } from "../../Types/ProductsInterface";

interface CartOverLayProps {
  handleShowCart: () => void;
  cartItems:any 
}
interface CartOverlayState {
  cartItems: CartProductType [];
}
class CartOverlay extends Component<CartOverLayProps,  CartOverlayState> {
  overlayRef: React.RefObject<HTMLDivElement>;
   

  constructor(props: CartOverLayProps) {
    super(props);
   
    this.overlayRef = React.createRef();
    this.handleClickOutside = this.handleClickOutside.bind(this);
    this.state = {
      cartItems: [
       
      ] 
    };
  }
 
  componentDidMount() {
    document.addEventListener("mousedown", this.handleClickOutside);

    let cartItemsLocal = localStorage.getItem("cart-product")
    if(cartItemsLocal){
 
      this.setState({
        cartItems :JSON.parse(cartItemsLocal) as CartProductType[]
      }) 
    }
    console.log(this.state.cartItems)
  }

  componentWillUnmount() {
    document.removeEventListener("mousedown", this.handleClickOutside);
  }

  handleClickOutside(event: MouseEvent) {
    if (this.overlayRef.current && !this.overlayRef.current.contains(event.target as Node)) {
      this.props.handleShowCart();
    }
  }

  render() {
    const { cartItems } = this.state;

    return (
      <div
     
        className="fixed inset-0 top-20 z-50 flex items-start justify-end bg-black bg-opacity-50"
      >
        <div    ref={this.overlayRef} className=" bg-white w-[425px] h-[628px] overflow-y-auto   mr-20 shadow-lg">
          <div><span  className="text-xl font-bold mb-4">My Beg,</span> <span>{cartItems.length} items</span></div>
          <div className="w-[100%] flex flex-col gap-10     ">
            {cartItems.length > 0 ? cartItems.map((val: CartProductType, i:number) => <CartItemCard key={val.id + i} {...val} />) : <div>No items in cart</div>}
          </div>
         
      
        </div>
      </div>
    );
  }
}

const mapStateToProps = (state: any) => ({});

const mapDispatchToProps = {
  handleShowCart
};

export default connect(mapStateToProps, mapDispatchToProps)(withRouter(CartOverlay));