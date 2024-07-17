import React, { Component } from "react";
import { Outlet } from "react-router-dom";
import Navbar from "./Components/Navbar";

export default class Layout extends Component {
  render() {
    return (
      <main>
        <Navbar />
        <Outlet />
      </main>
    );
  }
}
