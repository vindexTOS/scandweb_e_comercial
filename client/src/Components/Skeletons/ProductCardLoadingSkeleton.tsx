import React, { Component } from "react";

export default class ProductCardLoadingSkeleton extends Component {
  render() {
    return (
      <div className={this.style.mainDiv}>
        <div className={this.style.photoWrapper}>
          <div className={`${this.style.img} bg-gray-300 animate-pulse`} />
        </div>
        <div className={this.style.nameAndPriceWrapper}>
          <div
            className={`${this.style.name} bg-gray-300 animate-pulse`}
            style={{ height: "1rem", marginBottom: "0.5rem" }}
          />
          <div
            className={`${this.style.name} bg-gray-300 animate-pulse`}
            style={{ height: "0.75rem", width: "60%" }}
          />
          <div
            className={`${this.style.name} bg-gray-300 animate-pulse`}
            style={{ height: "0.75rem", width: "50%" }}
          />
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
