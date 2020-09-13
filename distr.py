import numpy

class subprogram:
    def __init__(self, prob_p , prob_q , j, i):

        i=int(i)
        j=int(j)

        draw=numpy.ndarray(shape=(i,j), dtype=float)
        marker=numpy.ndarray(shape=(i,j), dtype=bool)
        combined_cycle=numpy.zeros(shape=(i), dtype=int)
        output_cycle=numpy.zeros(shape=(i), dtype=int)
        input_cycle=numpy.zeros(shape=(i), dtype=int)
        probability=numpy.ones(shape=(i), dtype=float)
        probability_integral=numpy.zeros(shape=(i+1), dtype=float)
        probability_integral_fin=numpy.zeros(shape=(i+1), dtype=float)
        # I want to fill an array with two dimensions with a variable,
        #which depends on the column and
        # and the row
        # column is i this represents all the possible different alternations of consecutive event paths
        # row is j this is how many consecutive events we are calculating. This is limited
        # by the computer capacity ( roundabout 13 consecutive event usually otherwise waiting time gets long)

        # in the start the program generates a pattern into a variable "draw"
        # draw in the meaning "draw a ticket"
        # draw[possible path of consecutive events][number of the step within the path of event] can be either input or output
        for row in range(j) :
            j_s=row+1
            for column in range(i):
                print(' ',end='')
                u=2**j_s
                w=u/2
                v=1+column%u
                if v>w:
                    draw[column][row]=prob_q
                else:
                    draw[column][row]=prob_p
                #print(draw[column][row], end='')
            #print("\n")
        for column in range(i):
            row=0
            while row<(j-1):
                if (draw[column][row]==prob_q and draw[column][row+1]==prob_p):
                    marker[column][row]= True
                    marker[column][row+1]= True
                    combined_cycle[column]+=1
                    row+=2
                    continue
                else:
                    marker[column][row]= False
                    marker[column][row+1]= False
                    #import pdb; pdb.set_trace()
                row+=1

        for column in range(i):
            for row in range(j):
                if (draw[column][row]==prob_q and marker[column][row]==False):
                    input_cycle[column]+=1
                elif(draw[column][row]==prob_p and marker[column][row]==False):
                    output_cycle[column]+=1


    #Probability of one chain of consecutive event
        for column in range(i):
            for row in range(j):
                if(draw[column][row]==prob_q):
                    probability[column]*=prob_q
                else:
                    probability[column]*=prob_p

    # to make an integral over all probability of one chain of consecutive event
    # which then in result must be 1 over all events


        for column in range(i):
            for counter in range(column):
                #import pdb; pdb.set_trace()
                probability_integral[column]+=probability[counter]

        for column in range(i):
            #import pdb; pdb.set_trace()
            probability_integral_fin[column-1]=probability_integral[column]
        probability_integral_fin[i-1]=1

        #counter=0
        #for column in range(i):
        #    counter +=probability[column] * combined_output_input_cycle[column]
        #Area_combined_output_input_cycle = counter

        # 3 Times the Area for each combination
        # That is then resulting to the reach end result of all
        # Calculating the total area for each of COMBINE cycles
        #The Areas have no real meaning by themselfes!
        counter=0
        for column in range(i):
            counter +=probability[column] * combined_cycle[column]
        Area_combined_cycle = counter

        # Calculating the total area for each of OUTPUT cycles
        counter=0
        for column in range(i):
            counter +=probability[column] * output_cycle[column]
        Area_output_cycle = counter

        # Calculating the total area for each of INPUT cycles
        counter=0
        for column in range(i):
            counter +=probability[column] * input_cycle[column]
        Area_input_cycle = counter
        # So the total area is the sum of all the areas :
        Total_Area=Area_combined_cycle+Area_output_cycle+Area_input_cycle

        # And the relative areas of each different cycle types are end result

        Relative_Area_combined_cycle=Area_combined_cycle/Total_Area
        Relative_Area_output_cycle=Area_output_cycle/Total_Area
        Relative_Area_input_cycle=Area_input_cycle/Total_Area




        # Printouts for debugging
        # afterwards maybe only the important values would be exported out of this function or module
        #for row in range(j):
            #for column in range(i):
                #print('        ',end='')
                #print(marker[column][row], end='')
            #print("\n")
        #print("\n")
        '''
        for column in range(i):
            print(combined_cycle[column], end='')
            print('        ', end='')
        print("\n")

        for column in range(i):
            print(output_cycle[column], end='')
            print('        ', end='')
        print("\n")

        for column in range(i):
            print(input_cycle[column], end='')
            print('        ', end='')
        print("\n")

        for column in range(i):
            print(probability_integral_fin[column], end='')
            print(' ', end='')
        print("\n")
        '''
        #
        #print(Relative_Area_combined_cycle)
        #print(Relative_Area_output_cycle)
        #print(Relative_Area_input_cycle)
        self.comb=Relative_Area_combined_cycle
        self.out=Relative_Area_output_cycle
        self.inp=Relative_Area_input_cycle

# MAIN PROGRAM

if __name__ == '__main__':
    print('The input is done 24h per day')
    hours_output=input('How many hours per day output is done ? ')
    hours_output=float(hours_output)

    probability_p=24/(24+hours_output) # probability for input
    probability_q=1-probability_p # probability for input
    a=13 # how many events are following each other
    b=2**a # the amount of different paths


    tulos=subprogram(probability_p , probability_q , a, b)
    print('\n')
    print('Probability for combined cycle ', end='')
    print(tulos.comb)
    print('Probability for output cycle ', end='')
    print(tulos.out)
    print('Probability for input cycle ', end='')
    print(tulos.inp)
