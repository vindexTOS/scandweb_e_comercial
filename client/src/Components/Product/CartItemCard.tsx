import React, { Component } from 'react';
import { CartProductType, Attribute } from '../../Types/ProductsInterface';

interface CartItemCardProps extends CartProductType {
  count: number;
  handleCart: (product: any) => void;
  handleRemove: (product: any) => void;
}

class CartItemCard extends Component<CartItemCardProps> {
  renderAttributes(attributes: Attribute[], selectedAttrabutes: any) {
    return attributes?.map((attr: Attribute, index: number) => (
      <div className={this.styles.itemsWrapper} key={index} data-testid={`cart-item-attribute-${attr.name.toLowerCase().replace(/ /g, '-')}`}>
        <h2 className="font-bold text-[13px]">{attr.name.toUpperCase()}:</h2>
        <div className={this.styles.items}>
          {attr.items.map((item: any, i: number) => {
            if (attr.name === "Color" && attr.type === "swatch") {
              return (
                <div 
                  className={`${this.styles.item} ${selectedAttrabutes[attr.name] === item.value && "outline outline-4-red"}`}
                  key={i}
                  style={{ backgroundColor: item.value }}
                  data-testid={`cart-item-attribute-${attr.name.toLowerCase().replace(/ /g, '-')}-${item.value.toLowerCase().replace(/ /g, '-')}${selectedAttrabutes[attr.name] === item.value ? '-selected' : ''}`}
                >
                  {attr.name !== "Color" && item.value.toUpperCase()}
                </div>
              );
            } else {
              return (
                <div
                  className={`${this.styles.item} ${selectedAttrabutes[attr.name] === item.value && "outline outline-4-red"}`}
                  key={i}
                  data-testid={`cart-item-attribute-${attr.name.toLowerCase().replace(/ /g, '-')}-${item.value.toLowerCase().replace(/ /g, '-')}${selectedAttrabutes[attr.name] === item.value ? '-selected' : ''}`}
                >
                  {item.value.toUpperCase()}
                </div>
              );
            }
          })}
        </div>
      </div>
    ));
  }

  render() {
    const { id, name, photo, prices, attributes, selectedAttrabutes, count, handleCart, handleRemove } = this.props;

    return (
      <div onClick={() => console.log(this.props)} className={this.styles.mainDiv}>
        <div className={this.styles.infoDiv}>
          <div className="font-bold">{name.slice(0, 16)}</div>
          <div className="font-bold">
            <span>{prices[0].currency.symbol}</span>
            <span>{prices[0].amount}</span>
          </div>
          <div>{this.renderAttributes(attributes, selectedAttrabutes)}</div>
        </div>
        <div className={this.styles.addDiv}>
          <div onClick={() => handleCart(this.props)} className={this.styles.iconBox} data-testid="cart-item-amount-increase">+</div>
          <div data-testid="cart-item-amount">{count}</div>
          <div onClick={() => handleRemove(this.props)} className={this.styles.iconBox} data-testid="cart-item-amount-decrease">-</div>
        </div>
        <div className={this.styles.photoDiv}>
          <img className={this.styles.img} src={photo} />
        </div>
      </div>
    );
  }

  private styles = {
    mainDiv: 'min-h-[167px] w-[100%] flex justify-between',
    infoDiv: 'w-[164px] flex flex-col pl-2',
    addDiv: 'min-h-[167px] w-[50px] mr-1 flex flex-col items-center justify-between',
    iconBox: 'flex h-[24px] w-[24px] items-center justify-center outline outline-[1px] cursor-pointer',
    photoDiv: '',
    img: 'h-[167px] w-[121px]',
    itemsWrapper: "",
    items: "flex gap-2 flex-wrap",
    item: "w-[34px] h-[34px] text-[11px] flex items-center justify-center border-[1px] border-black text-gray-500",
  };
}

export default CartItemCard;