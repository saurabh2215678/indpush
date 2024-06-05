import React from "react";
import { Link } from "react-router-dom";
import Header from "../Components/Header";
import Banner from "../Components/Banner";
import Video from "../Components/Video";

const Home = () =>{
    return(
        <>
            <Header />  
            <Banner />
            <Video />
        </>
    )
}
export default Home;