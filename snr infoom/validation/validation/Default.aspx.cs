﻿using System;
using System.Collections.Generic;
using System.Linq;
using System.Web;
using System.Web.UI;
using System.Web.UI.WebControls;
using System.Text.RegularExpressions;
using System.Data;
using System.Data.SqlClient;

public partial class _Default : System.Web.UI.Page
{
    SqlConnection con = new SqlConnection("Data Source=.\\SQLEXPRESS;AttachDbFilename=|DataDirectory|\\saurabh.mdf;Integrated Security=True;User Instance=True");
    protected void Page_Load(object sender, EventArgs e)
    {

    }
    protected void Button1_Click(object sender, EventArgs e)
    {
        

        int i = 0, j = 0, k = 0,a=0,b=0,c=0;
        string email = TextBox2.Text;
        if (email.IndexOf("@") == -1 || email.IndexOf(".") == -1)
        {
            Label2.Visible = true;
 
            Label2.Text = "<font color ='Green'> invalid email address" + Button1.AccessKey + "</font>";
            i = 0;
        }
        else
        {
            Label2.Visible = true;
            Label2.Text = "valid email address.";
            i = 1;
        }


            if (!(new Regex(@"^[0-9]{10}$")).IsMatch(TextBox1.Text))
            {
                Label1.Visible = true;
            
                Label1.Text = "<font color ='Red'> number address is not valid" + Button1.AccessKey + "</font>";
                j = 0;


            }
            else
            {

                Label1.Visible = true;
                Label1.Text = "number address is  valid.";
                j = 1;
            }



            if (DropDownList1.SelectedItem.ToString() == "...select.....")
            {
             
                Label3.Text = "<font color ='Bule'> select one" + Button1.AccessKey + "</font>";
                k = 0;
            }
            else
            {
                Label3.Text = "value selected";
                k = 1;
            }
            if (!(new Regex(@"^[a-zA_Z'.\s]{1,20}$")).IsMatch(TextBox3.Text))
            {
                Label6.Visible = true;
                Label6.Text = "Name address is not valid.";

                a = 0;

            }
            else
            {

                Label6.Visible = true;
                Label6.Text = "Name address is  valid.";
                a = 1;
               
            }

            if (RadioButtonList1.SelectedValue.ToString() == "")
            {
                Label5.Text = "radio button not selected";
                b = 0;

            }
            else
            {
                Label5.Text = "radio button selected";
                b = 1;
            }

            if (CheckBox1.Checked)
            {

                Label7.Text = "check box selected";
                c = 1;
            }
            else
            {
                Label7.Text = "select checkbox";
                c = 0;
            }



            if (i==1 && j==1 && k==1 && a==1 && b==1 && c==1)
            {
            con.Open();
            string str = "insert into sp(number,email,country,gen,name) values(@number,@email,@country,@gen,@name)";
            SqlCommand cmd = new SqlCommand(str, con);
            cmd.Parameters.AddWithValue("@number",TextBox1.Text);
            cmd.Parameters.AddWithValue("@email",TextBox2.Text);
            cmd.Parameters.AddWithValue("@country",DropDownList1.SelectedValue.ToString());
            cmd.Parameters.AddWithValue("@gen", RadioButtonList1.Text);
            cmd.Parameters.AddWithValue("@name", TextBox3.Text);
            int l=cmd.ExecuteNonQuery();
            con.Close();
            if (l > 0)
               
            Label4.Text = "<font color ='Green'> submitted" + Button1.AccessKey + "</font>";
            
            }
            else
                Label4.Text = "fill correct values";
       
          
    }

    

   
}
