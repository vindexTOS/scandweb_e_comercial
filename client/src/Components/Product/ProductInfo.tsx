import React, { Component } from "react";
import { Attribute, Price } from "../../Types/ProductsInterface";
import Attributes from "./Attributes";

interface ProductInfoProps {
  attributes: Attribute[];
  description: string;
  name: string;
  prices: Price[];
}

export default class ProductInfo extends Component<ProductInfoProps> {
  render() {
    const { name, attributes, prices } = this.props;

    return (
      <div className={this.style.main}>
        <h1 className={this.style.header}>{name}</h1>
        <Attributes attributes={attributes} />
        <div className={this.style.price}>
          <h1 onClick={() => console.log(prices)}>PRICE:</h1>
          <div>
            <span>{prices[0].currency.symbol}</span>
            <span>{prices[0].amount}</span>
          </div>
        </div>
      </div>
    );
  }

  private style = {
    main: "flex flex-col gap-5",
    header: "text-[40px]",
    priceHeader: "text-[20px] font-bold ",
    price: "",
  };
}
