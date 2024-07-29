import React, { Component } from 'react';
import { CartProductType, Attribute } from '../../Types/ProductsInterface';

export default class CartItemCard extends Component<CartProductType> {
  renderAttributes(attributes: Attribute[]) {
    return attributes?.map((attr: Attribute, index: number) => (
        <div className={this.styles.itemsWrapper} key={index}>
          <h2 className="font-bold">{attr.name.toUpperCase()}:</h2>
          <div className={this.styles.items}>
            {attr.items.map((item: any, i: number) => {
              if (attr.name === "Color" && attr.type === "swatch") {
                return (
                  <div
                    className={this.styles.item}
                    key={i}
                    style={{ backgroundColor: item.value }}
                  >
                    {attr.name !== "Color" && item.value.toUpperCase()}
                  </div>
                );
              } else {
                return (
                  <div className={this.styles.item} key={i}>
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
    const { id, name, photo, prices, attributes } = this.props;

    return (
      <div onClick={() => console.log(this.props)} className={this.styles.mainDiv}>
        <div className={this.styles.infoDiv}>
          <div className="font-bold">{name.slice(0, 16)}</div>
          <div className="font-bold">
            <span>{prices[0].currency.symbol}</span>
            <span>{prices[0].amount}</span>
          </div>
          <div>{this.renderAttributes(attributes)}</div>
        </div>
        <div className={this.styles.addDiv}>
          <div className={this.styles.iconBox}>+</div>
          <div>1</div>
          <div className={this.styles.iconBox}>-</div>
        </div>
        <div className={this.styles.photoDiv}>
          <img className={this.styles.img} src={photo} />
        </div>
      </div>
    );
  }

  private styles = {
    mainDiv: 'min-h-[167px] w-[100%] flex justify-between',
    infoDiv: 'w-[164px] flex flex-col pl-2 ',
    addDiv: 'min-h-[167px] w-[50px] mr-1 flex flex-col items-center justify-between',
    iconBox: 'flex h-[24px] w-[24px] items-center justify-center outline outline-[1px]',
    photoDiv: '',
    img: 'h-[167px] w-[121px]',
    itemsWrapper: "",
    items: "flex gap-2  flex-wrap",
    item: "w-[34px] h-[34px]  text-[12px] flex items-center justify-center border-[1px] border-black text-gray-500",
  };
}