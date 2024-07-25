import React, { Component } from "react";

export default class CartOverlay extends Component {
  render() {
    return (
      <div className="fixed inset-0 top-20 z-50 flex items-start justify-end bg-black bg-opacity-50">
        <div className="bg-white w-[325px] h-[628px] overflow-y-auto p-4  mr-20 shadow-lg">
          <div className="text-xl font-bold mb-4">My Beg 12</div>

          <div className="divide-y divide-gray-200">
            <div className="flex items-center py-2">
              <div className="w-16 h-16 bg-gray-200 rounded-full"></div>
              <div className="ml-4">
                <div className="font-bold">My Beg</div>
                <div className="text-gray-500">$99.99</div>
              </div>
            </div>
          </div>
        </div>
      </div>
    );
  }
}
