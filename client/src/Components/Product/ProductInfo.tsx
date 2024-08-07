import React, { Component } from "react";
import { Attribute, CartProductType, Price } from "../../Types/ProductsInterface";
import Attributes from "./Attributes";
import { connect } from "react-redux";
import { addToCart } from "../../Store/Cart/Cart.slice";
import Status from "../Status/Status";
 
  

interface ProductInfoProps {
  attributes: Attribute[];
  description: string;
  name: string;
  inStock:boolean 
  id: string;
  prices: Price[];
  addToCart: (state: any) => void;
  cartProducts: any[];
  gallery:string[]
  attrabuteSelector:any
  product_id:string | number

}

interface ProductInfoState {
  isExpanded: boolean;
  numberOfItems: number;
  error:string 
  succ:string 
 
}

class ProductInfo extends Component<ProductInfoProps, ProductInfoState> {
  constructor(props: ProductInfoProps) {
    super(props);
    this.state = {
      isExpanded: false,
      numberOfItems: 0,
      error:"",
      succ:""
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


   handlError(err:string){
    this.setState({error: err})
    setTimeout(()=>{
      this.setState({error:""})

    },3000)
   }

   handleSuccsess(str:string){
     this.setState({succ:str})
     setTimeout(()=>{
      this.setState({succ:""})

    },3000)
   }
  handleCart(product:  CartProductType) {
    console.log(product)
    if(this.props.attributes && this.props.attributes.length >= 1 && !Object.keys(this.props.attrabuteSelector).length      ) {
      this.handlError("Chose attrabute")
    } else if(!this.props.inStock){ 
       
      this.handlError("Item is out of stock")


    } else{
       let cart:CartProductType[] = [];
   
  
      product["selectedAttrabutes"] =  this.props.attrabuteSelector
   
      const storedCart = localStorage.getItem("cart-product");
      if (storedCart) {
        cart = JSON.parse(storedCart);
      }
  
      cart.push(product);
      this.handleNumberCount(cart);
      localStorage.setItem("cart-product", JSON.stringify(cart));
  
      this.props.addToCart(product);
      this.handleSuccsess("item has been added!")
    }
    
    
  }
  toggleDescription = () => {
    this.setState((prevState) => ({
      isExpanded: !prevState.isExpanded,
    }));
  };

  render() {
    const { name, attributes, prices, description, id, gallery, product_id } = this.props;
const { isExpanded } = this.state;
const maxLength = 500;
const cleanHtmlString = (htmlString: string): string => {
   let cleanedHtml = htmlString.replace(/\\n/g, ''); 
  cleanedHtml = cleanedHtml.replace(/\s{2,}/g, ' '); 
  cleanedHtml = cleanedHtml.replace(/>\s+</g, '><');  
  return cleanedHtml.trim();
};
const HtmlRenderer: React.FC<any> = ({ html }) => {
 
  const cleanHtml = cleanHtmlString(html);
console.log(cleanHtml)
  const parseHtml = (htmlString: string) => {
    
    const tempDiv = document.createElement('div');
    tempDiv.innerHTML = htmlString;
    const nodes = Array.from(tempDiv.childNodes);

     return nodes.map((node, index) => {
      if (node.nodeType === Node.ELEMENT_NODE) {
        const TagName = node.nodeName.toLowerCase();
        const props: any = {};
         for (let attr of (node as HTMLElement).attributes) {
          props[attr.name] = attr.value;
        }
        return React.createElement(
          TagName,
          { key: index, ...props },
          (node as HTMLElement).innerHTML
        );
      } else if (node.nodeType === Node.TEXT_NODE) {
        return node.textContent;
      }
      return null;
    });
  };

  return <div>{parseHtml(cleanHtml)}</div>;
};


const renderDescription = () => {
  const truncatedText = description.length > maxLength ? description.slice(0, maxLength) + " ..." : description;
   
  return (
    <>
          <div className="w-[300px] cursor-pointer" data-testid="product-description">
            <HtmlRenderer html={isExpanded ? description : truncatedText} />
          </div>
          {description.length >= maxLength && (
            <button
              className="text-blue-500"
              onClick={this.toggleDescription}
            >
              {isExpanded ? "Show less" : "Read more"}
            </button>
          )}
        </>
  );
};
    return (
      <div className={this.style.main}>
        {this.state.error && <Status message={this.state.error } type="error"/>}
        {this.state.succ && <Status message={this.state.succ } type="succ"/>}

        <h1 className={this.style.header}>{name}</h1>
        <div data-testid="product-attributes">
          <Attributes attributes={attributes} />
        </div>
        <div className={this.style.price}>
          <h1
            className={this.style.priceHeader}
            onClick={() => console.log(prices)}
          >
            PRICE:
          </h1>
          <div className="font-bold">
            <span>{prices[0].currency.symbol}</span>
            <span>{prices[0].amount.toFixed(2)}</span>
          </div>
        </div>
        <button
          disabled={this.props.attributes && this.props.attributes.length >= 1 && !Object.keys(this.props.attrabuteSelector).length}
          onClick={() =>
            this.handleCart({ name, attributes, prices, description, id ,photo: gallery[0], product_id })
          }
          className={`${this.style.btn} ${this.props.attributes && this.props.attributes.length >= 1 && !Object.keys(this.props.attrabuteSelector).length ? 'bg-gray-300' : "bg-green-400"}`}
          data-testid="add-to-cart"
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
    btn: "  text-white   w-[292px] h-[52px]",
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
