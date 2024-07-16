import React, { Component } from "react";
import { Link } from "react-router-dom";
import Logo from "../assets/a-logo.png";
import Cart from "../assets/Empty Cart.png";
export default class Navbar extends Component {
  state = {
    navItems: [
      { id: 1, name: "WOMEN" },
      { id: 2, name: "MEN" },
      { id: 3, name: "KIDS" },
    ],
    selectedNavItem: "women",
  };
  render() {
    return (
      <nav className={this.styles.nav}>
        <section className={this.styles.navLinks}>
          {this.state.navItems.map((item) => (
            <div
              key={item.id}
              className={`cursor-pointer ${
                this.state.selectedNavItem === item.name
                  ? "text-green-500 border-b-2 border-green-500"
                  : ""
              }`}
              onClick={() => this.handleNavItemSelect(item.name)}
            >
              {item.name}
            </div>
          ))}
        </section>
        <div>
          <img src={Logo} />
        </div>
        <div>
          <img src={Cart} />
        </div>
      </nav>
    );
  }
  handleNavItemSelect(itemName: string) {
    this.setState({ selectedNavItem: itemName });
  }
  private styles = {
    nav: "h-[80px] w-[100%] flex items-center  justify-between px-20 ",
    navLinks: "flex justify-between  gap-10 ",
  };
}
