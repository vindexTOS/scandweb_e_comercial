import React, { Component } from "react";
import { Outlet } from "react-router-dom";
import Navbar from "./Components/Navbar";
import CartOverlay from "./Components/Product/CartOverLay";

export default class Layout extends Component {
  render() {
    return (
      <main>
        <Navbar />
        <CartOverlay />
        <Outlet />
      </main>
    );
  }
}
