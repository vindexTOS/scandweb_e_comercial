import React, { Component } from "react";
import { Routes, Route } from "react-router-dom";
import Layout from "./Layout";
import Home from "./Pages/Home";
import SingleCard from "./Pages/SingleCard";

interface AppState {
  message: string;
}

class App extends Component<{}, AppState> {
  render() {
    return (
      <Routes>
        <Route path="/" element={<Layout />}>
          <Route path="" element={<Home />} />
          <Route path="/:id" element={<SingleCard />} />
        </Route>
      </Routes>
    );
  }
}

export default App;
