import React, { Component } from "react";
import { Routes, Route, Router } from "react-router-dom";
import Layout from "./Layout";
import Home from "./pages/Home";

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
          <Route path="home" element={<Home />} />
        </Route>
      </Routes>
    );
  }
}

export default App;
