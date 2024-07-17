import React, { Component } from "react";
import { Routes, Route, Router, Navigate } from "react-router-dom";
import Layout from "./Layout";
import Home from "./Pages/Home";

interface AppState {
  message: string;
}

class App extends Component<{}, AppState> {
  constructor(props: {}) {
    super(props);
    this.state = {
      message: "Hello, world!",
    };
  }

  render() {
    return (
      <Routes>
        <Route path="/" element={<Layout />}>
          <Route path="" element={<Home />} />
        </Route>
      </Routes>
    );
  }
}

export default App;
