import React, { Component } from "react";
import { Attribute } from "../../Types/ProductsInterface";
import { handleAttrabuteSelector } from "../../Store/Cart/Cart.slice";
import { connect } from "react-redux";

interface AttributesProps {
  attributes: Attribute[] | null;
  attrabuteSelector:any
  handleAttrabuteSelector:(action:any)=>void;
}

 class Attributes extends Component<AttributesProps> {
  handleAttrabuteSelect(key:string ,value:string){
    this.props.handleAttrabuteSelector({key,value})
  }
  render() {
    const { attributes } = this.props;
    return (
      <>
        {attributes &&
          attributes.map((attr: Attribute, index: number) => (
            <div className={this.style.itemsWrapper} key={index}>
              <h2 className="font-bold">{attr.name.toUpperCase()}:</h2>
              <div className={this.style.items}>
                {attr.items.map((item: any, i: number) => {
                  if (attr.name === "Color" && attr.type === "swatch") {
                    return (
                      <div
                      onClick={()=>this.  handleAttrabuteSelect(attr.name, item.value)}
                        className={`${this.style.item} ${this.props.attrabuteSelector[attr.name] === item.value && "outline outline-4-red"}  `}
                        key={i}
                        style={{ backgroundColor: item.value  }}
                      >
                        {attr.name !== "Color" && item.value.toUpperCase()}
                        
                      </div>
                    );
                  } else {
                    return (
                      <div onClick={()=>this.handleAttrabuteSelect(attr.name, item.value)}                         className={`${this.style.item} ${this.props.attrabuteSelector[attr.name] === item.value && "outline outline-4-red"}  `}
                      key={i}>
                        {item.value.toUpperCase()}
                      </div>
                    );
                  }
                })}
              </div>
            </div>
          ))}
      </>
    );
  }




  
  private style = {
    itemsWrapper: "",
    items: "flex gap-2",
    item: "w-[63px] h-[45px]  flex items-center justify-center  text-gray-500 cursor-pointer",
  };
}


const mapStateToProps = (state: any) => ({
  attrabuteSelector: state.cart.attrabuteSelector,
});

const mapDispatchToProps = {
  handleAttrabuteSelector
};
export default connect(mapStateToProps, mapDispatchToProps)(Attributes )