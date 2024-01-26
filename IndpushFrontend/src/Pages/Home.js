import React from "react";
import { Link } from "react-router-dom";

const Home = () =>{
    return(
        <div className="center_div">
            <div>
                    <h4>INDPUSH</h4>
                    <h5 className="mb-5">Coming Soon</h5>
                    <Link class="form-control ms-2" to="/login">LOGIN</Link>
            </div>
          
        </div>
    )
}
export default Home;