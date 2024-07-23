import React, { Component } from "react";
import { Attribute } from "../../Types/ProductsInterface";

interface AttributesProps {
  attributes: Attribute[] | null;
}

export default class Attributes extends Component<AttributesProps> {
  render() {
    const { attributes } = this.props;
    return (
      <>
        {attributes &&
          attributes.map((attr: Attribute, index: number) => (
            <div className={this.style.itemsWrapper} key={index}>
              <h2>{attr.name.toUpperCase()}:</h2>
              <div className={this.style.items}>
                {attr.items.map((item: any, i: number) => {
                  if (attr.name === "Color" && attr.type === "swatch") {
                    return (
                      <div
                        className={this.style.item}
                        key={i}
                        style={{ backgroundColor: item.value }}
                      >
                        {attr.name !== "Color" && item.value.toUpperCase()}
                      </div>
                    );
                  } else {
                    return (
                      <div className={this.style.item} key={i}>
                        {item.displayValue}
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
    item: "w-[63px] h-[45px] flex items-center justify-center border-[1px] border-black text-gray-500",
  };
}
