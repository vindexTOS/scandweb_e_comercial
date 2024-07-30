import React, { Component } from "react";
import { Outlet } from "react-router-dom";
import Navbar from "./Components/Navbar";
import CartOverlay from "./Components/Product/CartOverLay";
import { connect } from "react-redux";
import withRouter from "./Routing/withRouter";

interface LayOutProps {
  showCart: boolean;
}

class Layout extends Component<LayOutProps> {
  render() {
    return (
      <main>
        <Navbar />
        {this.props.showCart && <CartOverlay />}
        <Outlet />
      </main>
    );
  }
}
const mapStateToProps = (state: any) => ({
  showCart: state.cart.showCart,
});

const mapDispatchToProps = {};
export default connect(mapStateToProps, mapDispatchToProps)(withRouter(Layout));
