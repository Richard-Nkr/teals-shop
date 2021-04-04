import React, {Component} from 'react';
import {createContext} from "react/cjs/react.production.min";

export const TealsShopContext = createContext();

class TealsShopContextProvider extends Component {
    constructor(props) {
        super(props);
        this.state = {

        }
    }
    render() {
        return (
            <TealsShopContext.Provider value={{
                ...this.state,
            }}>
                {this.props.children}
            </TealsShopContext.Provider>
        );
    }
}

export default TealsShopContextProvider;