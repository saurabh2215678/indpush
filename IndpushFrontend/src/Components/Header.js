import React from "react";
import { useSelector } from "react-redux";
import { Link } from "react-router-dom";

const Header = () =>{
    const user = useSelector((state) => state.user.user);
    return(
        <header>
            <Link to="/">INDPUSH</Link>
            <div className="header_nav">
                <ul>
                    <li><Link to="/">Home</Link></li>
                    <li><a href="#Features">Features</a></li>
                    <li><a href="#Pricing">Pricing</a></li>
                    <li><a href="#Contact">Contact</a></li>
                    {user ?
                        <li><Link to="/dashboard">Dashboard</Link></li> : 
                        <li><Link to="/login">Login</Link></li>
                    }
                </ul>
            </div>
        </header>
    )
}
export default Header;