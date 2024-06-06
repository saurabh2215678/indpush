import React from "react";
import "./Brand.css";

const Brand = () => {
    return (
        <section>
            <div className="container text-center position-relative">
                <div className="col-md-8 offset-md-2">
                    <h2>🥇 Brands Who <span className="text-primary">Trust</span> US</h2>
                    <div className="saperator"></div>
                    <p className="mt-4 mr-xl-5 phone">We have lots of satisfied customers who use LaraPush regularly to send notifications to their subscribers. <br />Some even have more than 400 million subscribers. <br /><b>You can trust us 🤝</b></p>
                    
                    <ul className="image-row mt-5">
                        <li>
                        {projects.map(p => {
                            return <img key={p.id} src={p.src} alt="" />;
                        })}
                        </li>
                    </ul>
                </div>
            </div>
        </section>
    )
}

export default Brand; 



// myData.js
export const projects = [
    {
      id: 1,
      src: "https://larapush.com/assets/images/customers/1.webp"
    },
    {
      id: 2,
      src: "https://larapush.com/assets/images/customers/2.webp"
    },
    {
        id: 3,
        src: "https://larapush.com/assets/images/customers/9.webp"
      },
      {
        id: 4,
        src: "https://larapush.com/assets/images/customers/7.webp"
      },
      {
        id: 5,
        src: "https://larapush.com/assets/images/customers/4.webp"
      },
      {
        id: 6,
        src: "https://larapush.com/assets/images/customers/5.webp"
      },
      {
        id: 7,
        src: "https://larapush.com/assets/images/customers/3.webp"
      }
      ,
      {
        id: 8,
        src: "https://larapush.com/assets/images/customers/6.webp"
      }
      ,
      {
        id:9,
        src: "https://larapush.com/assets/images/customers/8.webp"
      }
  ];