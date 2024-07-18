import React, { Component } from "react";
import { Product } from "../Types/ProductsInterface";

interface ProductCardProps {
  product: Product;
}

export default class ProductCard extends Component<ProductCardProps> {
  render() {
    const { product } = this.props;

    return (
      <div onClick={() => console.log(product)} className={this.style.mainDiv}>
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
      </div>
    );
  }

  private style = {
    mainDiv:
      "w-[368px] h-[400px]  hover:shadow-xl flex  flex-col items-center ",
    img: "w-[354px]  h-[330px] p-2",
    nameAndPriceWrapper:
      "flex flex-col justify-start items-start w-[100%] px-5",
    name: "text-gray-400",
    photoWrapper: "relative",
    outofstock: "absolute  top-40 left-[4rem] text-[2rem] text-gray-200",
  };
}
